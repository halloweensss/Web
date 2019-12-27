<?php
namespace app\components;
use app\models\User;
use InstagramScraper\Instagram;

require __DIR__ . '/../vendor/autoload.php';

class InstagramHelper
{
    public static function getPosts($name, $pagintate, $instagram){

        $account = $instagram->getAccount($name);

        //$medias= $instagram->getPaginateMediasByUserId($account->getId(),2,$pagintate);
        //$medias = $instagram->getPaginateMedias($name,$pagintate);
        $medias = $instagram->getMedias($name);
        $result = [];
        foreach ($medias as $media){
            //$url = $media->getLink();
            //$media = $instagram->getMediaByUrl($url);
            $date = getdate($media->getCreatedTime());
            $item = [
                'id'=>$media->getId(),
                'username'=>$account->getFullName(),
                'login'=>'@'. $account->getUsername(),
                'serviceName'=> "instagram",
                'accountUrl'=>"https://www.instagram.com/".$account->getUsername()."/",
                'avatarUrl'=>$account->getProfilePicUrl(),
                'imageUrl'=>self::getContent($instagram,$media),
                'carouselUrl'=>null,
                'postUrl'=>$media->getLink(),
                'postText'=>$media->getCaption(),
                'postLikes'=>$media->getLikesCount(),
                'postComments'=>$media->getCommentsCount(),
                'postViews'=>null,
                'postDate'=>$date['mday']. "." . $date['mon']. "." . $date['year']. " ". $date['hours'].":".$date['minutes'],
                'postDateNum'=>$media->getCreatedTime(),
                'type'=>$media->getType(),
                //'HasNextPage'=>$medias['hasNextPage'],
                //'MaxId' => $medias['maxId']
            ];
            $result[]= $item;
        }
        return $result;
    }

    public function getPostsFromFollowers($names){
        $result = [];
        $instagram = new Instagram();
        foreach ($names as $name){
            $result = array_merge($result, self::getPosts($name,null,$instagram));
            //$result = $result + self::getPosts($name,null);
            usort($result, array("app\\components\\InstagramHelper", "time_sort"));
            //$result = array_slice($result, 0, 20);
        }

        return $result;
    }

    function time_sort($x, $y){
        return ($x['postDateNum'] < $y['postDateNum']);
    }

    public static function getContent($instagram,$media)
    {
        $type = $media->getType();
        if ($type == "carousel") {
            $url = $media->getLink();
            $media = $instagram->getMediaByUrl($url);
            $result = [];
            foreach ($media->getCarouselMedia() as $carousel) {
                $typeCarousel = $carousel->getType();
                if ($typeCarousel == "video") {
                    $result[] = $carousel->getVideoStandardResolutionUrl();
                } elseif ($typeCarousel == 'image') {
                    $result[] = $carousel->getImageHighResolutionUrl();
                }
            }
            return (Array)$result;
        } else if ($type == "sidecar") {
            $url = $media->getLink();
            $media = $instagram->getMediaByUrl($url);
            $result = [];
            foreach ($media->getSidecarMedias() as $sidecarMedia) {
                $typeSidecar = $sidecarMedia->getType();
                if ($typeSidecar == "video") {
                    $result[] = $sidecarMedia->getImageHighResolutionUrl();
                } elseif ($typeSidecar == 'image') {
                    $result[] = $sidecarMedia->getImageHighResolutionUrl();
                }
            }
            return (Array)$result;
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
        $user = $instagram->getAccount($name);
        if($user == null)
            return null;
        $item =[
            'id'=>$user->getId(),
            'username'=>$user->getUsername(),
            'serviceName'=>"instagram",
            'follow'=>false,
            'profileUrl'=>"https://www.instagram.com/".$user->getUsername()."/"
        ];
        return $item;
    }

    public static function getAccountsByName($name){
        $instagram = new Instagram();
        $accounts = $instagram->searchAccountsByUsername($name);
        $result = [];
        foreach ($accounts as $account){
            $item =[
                'id'=>$account->getId(),
                'username'=>$account->getUsername(),
                'serviceName'=>"instagram",
                'follow'=>false,
                'profileUrl'=>"https://www.instagram.com/".$account->getUsername()."/"
            ];
            $result[] = $item;
        }
        return $result;
    }
}