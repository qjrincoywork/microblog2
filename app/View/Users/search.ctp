
<?php
    $paginator = $this->Paginator;
    $myId = $this->Session->read('User')['id'];
?>
<!-- <div class="container default-tab pt-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="true">Similar Users</a>
        </li>
        <li class="nav-item">
            <a class="get_posts nav-link" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="false">Similar Posts</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
            
        </div>
        <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
            <div class="container pt-4">
                <div class="posts-container container"></div>
            </div>
        </div>
    </div>
</div> -->
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