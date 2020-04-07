<?php if(!empty($profile)):?>
    <?php
        $paginator = $this->Paginator;
        $id = $this->Session->read('User')['id'];
        $userId = $profile['User']['id'];
        $myPost = $userId === $id ? true : false;

        $editPicHref = $this->Html->url(['controller' => 'users', 'action' => 'editPicture', 'id' => $userId]);
        $picClass = $myPost ? 'update_picture' : '';
        $editPicHref = $myPost ? "href='".$editPicHref."'" : '';

        $joined = date(' M Y', strtotime($profile['User']['created']));
        $myPic = $this->System->getUserPic($userId);
        $myFullName = $this->System->getFullNameById($userId);
    ?>
    <div class="container-fluid border mt-3">
        <div class="row">
            <div class="wrapper col-sm-3 user-profile-pic">
                <img type='button' src='<?=$myPic?>'class="mx-auto p-2">
                <?php if($myPost):?>
                <div class="overlay">
                    <a href="#" class="icon" title='Change Picture'>
                        <i class="<?=$picClass?> fas fa-camera" <?=$editPicHref?>></i>
                    </a>
                </div>
                <?php endif;?>
            </div>
            <div class="col-sm-9 user-profile-details">
                <?php
                    if($myPost){
                        $button = "<div class='follow-button col-sm-12 mt-3'>
                                        <button href='".$this->Html->url(['controller' => 'users', 'action' => 'edit', 'id' => $userId])."' type='button' class='edit_profile btn-sm btn-outline-primary'>Edit profile</button>
                                </div>";
                    } else {
                        $isFollowing = $this->System->isFollowing($id, $userId);
                        $btnTitle = $isFollowing ? 'Unfollow' : 'Follow';
                        $btnClass = $isFollowing ? 'unfollow_user btn-outline-danger' : 'follow_user btn-outline-primary';
                        
                        $button = "<div class='follow-button col-sm-12 mt-3'>
                                        <button href='".$this->Html->url(['controller' => 'users', 'action' => 'follow'])."' type='button' class='".$btnClass." btn-sm' followingId='".$userId."'>".$btnTitle."</button>
                                    </div>";
                    }
                    echo $button;
                ?>    
                <div class="row">
                    <div class="col-sm-12 profile-fullname">
                        <h3><?=$myFullName?></h3>
                    </div>
                    <div class="col-sm-12 row m-2">
                        <div class="date-joined m-2">
                            <h5 class="text-secondary"><i class="far fa-calendar-alt"></i> Joined <?= $joined ?></h5>
                        </div>
                        <div class="email m-2">
                            <h5 class="text-secondary"><i class="fas fa-at"></i> <?= $profile['UserProfile']['email'] ?></h5>
                        </div>
                    </div>
                    <div class="col-sm-12 row">
                        <div class="following p-2">
                            <button href='<?=$this->Html->url(['controller' => 'users', 'action' => 'following', 'user_id' => $userId])?>' class="get_follow btn-sm btn-outline-primary">Following</button>
                        </div>
                        <div class="followers ml-5 p-2">
                            <button href='<?=$this->Html->url(['controller' => 'users', 'action' => 'following', 'following_id' => $userId])?>' class="get_follow btn-sm btn-outline-primary">Followers</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<div id="profile-post-container">
    <?php
        if(isset($data)) {
            $article = '';
            foreach ($data as $key => $value) {
                $gender = $value['UserProfile']['gender'];
                $profilePic = $value['UserProfile']['image'];
                $postAgo = $value['Post']['post_ago'];
                $postId = $value['Post']['id'];
                $postUserId = $value['Post']['user_id'];
                $myPost = $postUserId === $id ? true : false ;
                
                $isLiked = $this->System->postReaction($postId, $id, 'Like');
                $isCommented = $this->System->postReaction($postId, $id, 'Comment');
                $isShared = $this->System->postReaction($postId, $id, 'Share');
                
                $likeCount = $this->System->reactionCount($postId, 'Like');
                $commentCount = $this->System->reactionCount($postId, 'Comment');
                $shareCount = $this->System->getPostCount($postId);

                $classListener = $value['Post']['deleted'] ? 'restore_post fas fa-recycle' : 'delete_post fa fa-trash';
                $title = $value['Post']['deleted'] ? 'Restore' : 'Delete';
                
                $article .= "<div class='post-container border'>";
                $article .= "   <div class='row'>
                                    <div class='post-img col-sm-2'>";
                $article .=     "<img src='$myPic'>";
                $article .= "   </div>";

                $article .= "<div class='post-details col-sm-10'>
                                <div class='row'>";
                            if($myPost) {
                            $article .= "<div class='system-action-buttons col-sm-12'>
                                            <button class='ml-2'>
                                                <span href='".$this->Html->url(['controller' => 'posts', 'action' => 'edit', 'post_id' => $postId])."' class='edit_post fa fa-edit' data-toggle='tooltip' data-placement='top' title='Edit' type='button'></span> 
                                            </button>
                                            <button class=''>
                                                <span href='".$this->Html->url(['controller' => 'posts', 'action' => 'delete', 'post_id' => $postId])."' class='".$classListener."' data-toggle='tooltip' data-placement='top' title='".$title."' type='button'></span> 
                                            </button>
                                        </div>";
                            }
                $article .=         "<div class='post-user'><a href='".$this->Html->url(['controller' => 'users', 'action' => 'profile', 'user_id' => $userId])."'>"
                                        .$myFullName.
                                    "</a></div>
                                    <div class='post-ago'>
                                        $postAgo
                                    </div>
                                    <div class='post-content col-sm-12'>
                                        <p>".$value['Post']['content']. "<p>
                                    </div>";

                            if($value['Post']['post_id']) {
                                $sharedPost =  $this->System->getSharedPost($value['Post']['post_id']);

                                $sharedFullName =  $this->System->getFullNameById($sharedPost['Post']['user_id']);
                                $sharedProfile =  $this->System->getUserPic($sharedPost['Post']['user_id']);
                                $sharedProfile = $sharedPost['UserProfile']['image'];
                                $sharedPostAgo = $sharedPost['Post']['post_ago'];
                                $sharedContent = $sharedPost['Post']['content'];
                                
                                $sharePost = "<div class='share-post border p-3 m-2'>";
                                
                                $sharePost .= "   <div class='row'>
                                                    <div class='post-img col-sm-2'>";
                                $sharePost .=     "<img src='$sharedProfile'>";
                                $sharePost .= "   </div>";

                                $sharePost .= "<div class='post-details col-sm-10'>
                                                    <div class='row'>
                                                        <div class='post-user'><a href='".$this->Html->url(['controller' => 'users', 'action' => 'profile', 'user_id' => $sharedPost['Post']['user_id']])."'>"
                                                            .$sharedFullName.
                                                        "</a></div>
                                                        <div class='post-ago'>
                                                            $sharedPostAgo
                                                        </div>
                                                        <div class='post-content col-sm-12'>
                                                            <p>".$sharedContent. "<p>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>";
                                $article .= $sharePost;
                            }

                $article  .=  "</div>
                            </div>
                        </div>";
                $buttons = "<div class='post-buttons border-top'>
                                <div class='row'>
                                    <button href='".$this->Html->url(['controller' => 'comments', 'action' => 'add', 'post_id' => $postId])."' postid='$postId' class='comment_post col-sm-3'>
                                        <span class='" . ($isCommented ? 'fas' : 'far') ." fa-comment' data-toggle='tooltip' data-placement='top' title='Comment'> ". (!empty($commentCount) ? $commentCount : '')."</span>
                                    </button>
                                    <button href='".$this->Html->url(['controller' => 'likes', 'action' => 'add'])."' class='like_post col-sm-3' postid='$postId'>
                                        <span class='" . ($isLiked ? 'fas' : 'far') ." fa-heart' data-toggle='tooltip' data-placement='top' title='Like'> ". (!empty($likeCount) ? $likeCount : '') ."</span>
                                    </button>
                                    <button href='".$this->Html->url(['controller' => 'posts', 'action' => 'share', 'post_id' => $postId])."' class='share_post col-sm-3' postid='$postId'>
                                        <span class='" . ($isShared ? 'fas' : 'far') ." fa-share-square' data-toggle='tooltip' data-placement='top' title='Share'> ". (!empty($shareCount) ? $shareCount : '')  ."</span>
                                    </button>
                                    <a href='".$this->Html->url(['controller' => 'posts', 'action' => 'view', 'post_id' => $postId])."' class='col-sm-3' postid='$postId'>
                                        <span class='fa fa-eye' data-toggle='tooltip' data-placement='top' title='View post'></span>
                                    </a>
                                </div>
                            </div>";
                $article .= $buttons;
                $article .= "</div>";
            }
            echo $article;
            
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
            echo "<span class='container'><h2> No User Found </h2></span>";
        }
    ?>
</div>