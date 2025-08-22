<?php
namespace App\Controllers\Admin;

use App\Models\RolesPermissionsModel;
use App\Models\UserNotificationModel;

class NotificationController extends AdminController
{
	public $session; 
    public $segment; 
    public $db; 
    public $validation; 
    public $encrypter; 
    public $lang_base_url;
    public $selected_lang;
    public $general_settings;
    public $agent;
    public $analytics;
    public $file_count;
    public $file_per_page;
    public $data;
    protected UserNotificationModel $userNotis;

    public function __construct()
    {
        $this->userNotis = new UserNotificationModel();
    }

    public function unreadCount()
    {
        $uid = 1; // replace with your auth helper
        return $this->response->setJSON([
            'count' => $this->userNotis->unreadCountFor($uid),
        ]);
    }

    public function list()
	{
		$uid    = 1;                       // your auth helper
		$limit  = (int) ($this->request->getGet('limit') ?? 20);
		$page   = max(1, (int) ($this->request->getGet('page') ?? 1));
		$offset = ($page - 1) * $limit;

		$builder = $this->userNotis
			->select('user_notifications.id AS pivot_id, user_notifications.is_read, user_notifications.read_at, notifications.*')
			->join('notifications', 'notifications.id = user_notifications.notification_id', 'left')
			->where('user_notifications.user_id', $uid)
			->orderBy('notifications.created_at', 'DESC');

		$items = $builder->limit($limit, $offset)->get()->getResultArray();

		// total for pagination (all user rows)
		$total = (clone $this->userNotis)
			->where('user_id', $uid)
			->countAllResults();

		$items = array_map(function($r){
			return [
				'pivot_id'   => (int) $r['pivot_id'],
				'id'         => (int) $r['id'],
				'type'       => $r['type'],
				'title'      => $r['title'],
				'message'    => $r['message'],
				'link'       => $r['link'],
				'level'      => $r['level'],
				'is_read'    => (bool) $r['is_read'],
				'created_at' => $r['created_at'],
			];
		}, $items ?? []);

		return $this->response->setJSON([
			'items'    => $items,
			'total'    => $total,
			'page'     => $page,
			'limit'    => $limit,
			'hasMore'  => ($offset + $limit) < $total,
		]);
	}

	/** Full-page view: /admin/notifications/all */
	public function index()
	{
		$uid     = 1;
		$perPage = (int) ($this->request->getGet('perPage') ?? 20);
		$page    = max(1, (int) ($this->request->getGet('page') ?? 1));
		$offset  = ($page - 1) * $perPage;

		$builder = $this->userNotis
			->select('user_notifications.id AS pivot_id, user_notifications.is_read, user_notifications.read_at, notifications.*')
			->join('notifications', 'notifications.id = user_notifications.notification_id', 'left')
			->where('user_notifications.user_id', $uid)
			->orderBy('notifications.created_at', 'DESC');

		$items = $builder->get()->getResultArray();

		$data = array_merge($this->data, [
			'title' => trans('notifications'),
			'items'   => $items,
			]);
			
		return view('admin/notifications/index', $data);
	}


    public function markRead($pivotId)
    {
        $uid = 1;
        $row = $this->userNotis->where(['id'=>$pivotId, 'user_id'=>$uid])->first();
        if (!$row) return $this->response->setStatusCode(404)->setJSON(['error'=>'Not found']);

        $this->userNotis->update($pivotId, ['is_read'=>1, 'read_at'=>date('Y-m-d H:i:s')]);
        return $this->response->setJSON(['ok'=>true]);
    }

    public function markAllRead()
    {
        $uid = 1;
        $this->userNotis->where(['user_id'=>$uid, 'is_read'=>0])
            ->set(['is_read'=>1, 'read_at'=>date('Y-m-d H:i:s')])->update();
        return $this->response->setJSON(['ok'=>true]);
    }
}
