
<?php
    $paginator = $this->Paginator;
    $myId = $this->Session->read('Auth.User')['id'];
?>
<div class="container default-tab pt-4">
<?php
    if($data) {
        $user = "<div class='container pt-4'>";
        foreach ($data as $val) {
            $fullname = $this->System->getFullNameById($val['User']['id']);
            $joined = date(' M Y', strtotime($val['User']['created']));
            $me = $myId === $val['User']['id'] ? true : false;
            
            $user .= "<div class='container-fluid border'>";
            $user .= "<div class='row'>";
            $user .=         "<div class='p-0 m-2 col-sm-1'>
                                    <img src='".$val['UserProfile']['image']."'class='mx-auto'>
                                </div>
                                <div class='row col-sm-11'>
                                    <div class='post-user col-sm-6 mt-3'><a href='".$this->Html->url(['controller' => 'users', 'action' => 'profile', 'user_id' => $val['User']['id']])."'>
                                    $fullname
                                    </a></div>";
                            if(!$me) {
                            $isFollowing = $this->System->isFollowing($myId, $val['User']['id']);
                            $btnTitle = $isFollowing ? 'Unfollow' : 'Follow';
                            $btnClass = $isFollowing ? 'unfollow_user btn-outline-danger' : 'follow_user btn-outline-primary';
            $user .=        "<div id='buttons-container' class='follow-button col-sm-5 mt-3'>
                                <button href='".$this->Html->url(['controller' => 'users', 'action' => 'follow'])."' type='button' class='".$btnClass." btn-sm' followingId='".$val['User']['id']."'>".$btnTitle."</button>
                            </div>";
                            }
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
        echo $user;

        echo "<nav class='paging'>";
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
        echo "</nav>";
    } else {
        echo "<span class='container'><h2>No matched found</h2></span>";
    }
?>
</div>