<?php
namespace App\Services;

use App\Models\NotificationModel;
use App\Models\UserNotificationModel;
use CodeIgniter\Database\Exceptions\DataException;

class NotificationService
{
    public function __construct(
        protected NotificationModel    $notis = new NotificationModel(),
        protected UserNotificationModel $userNotis = new UserNotificationModel(),
    ) {}

    /**
     * @param string          $type   e.g. "form.captain", "form.contact", "user.registered", "listing.created", "subscription.created"
     * @param string          $title
     * @param string|null     $message
     * @param string|null     $link   URL to admin detail page
     * @param array           $data   any extra payload (will be json-encoded)
     * @param array|int|str   $recipients  array of user IDs, single user ID, or special 'admins'
     * @param string          $level  info|success|warning|error
     */
    public function create(
        string $type,
        string $title,
        ?string $message = null,
        ?string $link = null,
        array $data = [],
        array|int|string $recipients = 'admins',
        string $level = 'info'
    ): int
    {
        $id = $this->notis->insert([
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'link'    => $link,
            'data'    => $data ? json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) : null,
            'level'   => $level,
        ], true);

        foreach ($this->resolveRecipients($recipients) as $uid) {
            $this->userNotis->insert([
                'notification_id' => $id,
                'user_id'         => $uid,
            ]);
        }

        return $id;
    }

    protected function resolveRecipients(array|int|string $recipients): array
    {
        if ($recipients === 'admins') {
            // Adjust this to your user model / role system
            $db = db_connect();
            $rows = $db->table('users')->select('id')->where('role', 1)->get()->getResultArray();
            return array_map(fn($r) => (int)$r['id'], $rows);
        }
        if (is_int($recipients)) return [$recipients];
        return $recipients;
    }
}
