<?php
    $myId = $this->Session->read('User')['id'];
    pr($data);
    /* pr($data[0]);
    die('hit'); */
    /* $userId = $data[0]['User']['id'];
    $myPost = $userId === $id ? true : false;
    $joined = date(' M Y', strtotime($data[0]['User']['created']));
    $myPic = $this->System->getUserPic($userId);
    $myFullName = $this->System->getFullNameById($userId); */
?>
<?php
    if(!empty($data[0]['Follow'])) {
        /* $user = "<div class='container pt-4'>";
        foreach ($data[0]['Follow'] as $following) {
            $fullname = $this->System->getFullNameById($following['following_id']);
            $profilePic = $this->System->getUserPic($following['following_id']);
            $joined = $this->System->getDateJoined($following['following_id']);
            $isFollowing = $this->System->isFollowing($myId, $following['following_id']);

            $btnTitle = $isFollowing ? 'Following' : 'Follow';
            $btnClass = $isFollowing ? 'unfollow_user btn-success' : 'follow_user btn-primary';
            
            $user .= "<div class='container-fluid border'>";

            $user .= "<div class='row'>";
            $user .=         "<div class='p-0 m-2 col-sm-1'>
                                    <img src='".$profilePic."'class='mx-auto'>
                                </div>
                                <div class='row col-sm-11'>
                                    <div class='post-user col-sm-6 mt-3'>
                                    $fullname
                                    </div>";
            $user .=         "<div id='buttons-container' class='follow-button col-sm-5 mt-3'>
                                        <button href='".$this->Html->url(['controller' => 'users', 'action' => 'follow'])."' type='button' class='".$btnClass." btn-sm' followingId='".$following['following_id']."'>".$btnTitle."</button>
                                    </div>";
            $user .=       "<div class='post-content mb-3 col-sm-12'>
                                        <span>
                                        <h5 class='text-secondary'><i class='far fa-calendar-alt'></i> Joined $joined</h5>
                                    </span>
                                    </div>";
            $user .=      "</div>";
            $user .=    "</div>";
            $user .= "</div>";
        }
        $user .=     "</div>";
        echo $user; */

        /* echo "<nav class='paging'>";
        echo $paginator->First('First');
        echo "  ";
        
        if($paginator->hasPrev()) {
            echo $paginator->prev('Prev');
        }
        echo "  ";
        
        echo $paginator->numbers(['modulus' => 2]);
        echo "  ";
        
        if($paginator->hasNext()) {
            echo $paginator->next("Next");
        }
        echo "  ";

        echo $paginator->last('Last');
        echo "</nav>"; */
    } else {
        echo "<span class='container'><h2>No matched found</h2></span>";
    }
?>