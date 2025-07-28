<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); 
function getVideoEmbedUrl($url) {
    // YouTube embed
    if (strpos($url, 'youtube.com/embed/') !== false || strpos($url, 'youtu.be/') !== false || strpos($url, 'youtube.com/watch') !== false) {
        // Short YouTube URL
        if (strpos($url, 'youtu.be/') !== false) {
            $videoId = ltrim(parse_url($url, PHP_URL_PATH), '/');
            return 'https://www.youtube.com/embed/' . $videoId;
        }

        // YouTube embed URL
        if (strpos($url, 'youtube.com/embed/') !== false) {
            return $url;
        }

        // YouTube watch URL
        $query = parse_url($url, PHP_URL_QUERY);
        if ($query) {
            parse_str($query, $params);
            if (!empty($params['v'])) {
                return 'https://www.youtube.com/embed/' . $params['v'];
            }
        }
    }

    // Vimeo embed
    if (strpos($url, 'vimeo.com/') !== false) {
        $path = parse_url($url, PHP_URL_PATH);
        if (preg_match('#/(\d+)#', $path, $matches)) {
            $videoId = $matches[1];
            return 'https://player.vimeo.com/video/' . $videoId;
        }
    }

    // Unknown or invalid
    return '';
}
?>
<main class="bg-gray pt-4 pt-sm-5">  
<div class="blogs bg-gray text-center" style="background: none;">	<div class="pageTitle py-2 text-center">		<h2 class="fw-bolder">Videos</h2>	</div>
	<div class="container py-3 py-xl-5 px-xxl-5">
		<div class="row row-cols-1 row-cols-sm-3 justify-content-center g-4 pb-3">		
		<?php if(!empty($videos)){ foreach($videos as $video){ ?>		
			<div class="col">
				
				<div class="bg-white pb-4" style="position:relative;">
					<div class="w-100">
						<iframe width="100%" height="315" 
								src="<?php echo htmlspecialchars(getVideoEmbedUrl($video->video_url)); ?>" 
								title="YouTube video player" 
								frameborder="0" 
								allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
								allowfullscreen>
						</iframe>

					</div>
					<div class="blogCol-Btm p-3 d-flex align-items-center flex-column">
						<h6 class="dblue title-xs px-2"><?php echo $video->name; ?></h6>
						
					</div>
				</div>
				
			</div>
		<?php } } ?>
		</div>
	</div>
</div>
</main>		
<?= $this->endSection() ?>