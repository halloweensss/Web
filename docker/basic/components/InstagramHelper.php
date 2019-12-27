<?php
namespace app\components;
use InstagramScraper\Instagram;

require __DIR__ . '/../vendor/autoload.php';

class InstagramHelper
{
    public static function getPosts($name){

        $instagram = new Instagram();
        $medias = $instagram->getMedias($name,20);
        $account = $instagram->getAccount($name);
        $result = [];
        foreach ($medias as $media){
            $url = $media->getLink();
            $media = $instagram->getMediaByUrl($url);
            $date = getdate($media->getCreatedTime());
            $item = [
                'id'=>$media->getId(),
                'username'=>$account->getFullName(),
                'login'=>'@'. $account->getUsername(),
                'serviceName'=> "instagram",
                'accountUrl'=>"https://www.instagram.com/".$account->getUsername()."/",
                'avatarUrl'=>$account->getProfilePicUrl(),
                'imageUrl'=>self::getContent($media),
                'carouselUrl'=>null,
                'postUrl'=>$media->getLink(),
                'postText'=>$media->getCaption(),
                'postLikes'=>$media->getLikesCount(),
                'postComments'=>$media->getCommentsCount(),
                'postViews'=>null,
                'postDate'=>$date['mday']. "." . $date['mon']. "." . $date['year']. " ". $date['hours'].":".$date['minutes'],
                'type'=>$media->getType()
            ];
            $result[]= $item;
        }
        return $result;
    }

    public static function getContent($media)
    {
        $type = $media->getType();
        if ($type == "carousel") {
            $result = [];
            foreach ($media->getCarouselMedia() as $carousel) {
                $typeCarousel = $carousel->getType();
                if ($typeCarousel == "video") {
                    $result[] = $carousel->getVideoStandardResolutionUrl();
                } elseif ($typeCarousel == 'image') {
                    $result[] = $carousel->getImageHighResolutionUrl();
                }
            }
            return $result;
        } else if ($type == "sidecar") {
            $result = [];
            foreach ($media->getSidecarMedias() as $sidecarMedia) {
                $typeSidecar = $sidecarMedia->getType();
                if ($typeSidecar == "video") {
                    $result[] = $sidecarMedia->getImageHighResolutionUrl();
                } elseif ($typeSidecar == 'image') {
                    $result[] = $sidecarMedia->getImageHighResolutionUrl();
                }
            }
            return $result;
        } else if ($type == "video") {
            return (Array)$media->getVideoStandardResolutionUrl();
        } else if ($type == "image") {
            return (Array)$media->getImageHighResolutionUrl();
        }
        return null;
    }

    public static function getAccountByName($name)
    {
        $instagram = new Instagram();
        return $instagram->getAccount($name);
    }
}