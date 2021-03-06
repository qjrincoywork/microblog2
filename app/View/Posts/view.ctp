<?php if(empty($data)):?>
        <span class='container'><h2>Post Deleted</h2></span>
<?php else:?>
<?php
    $paginator = $this->Paginator;
    $content = $data['Post']['content'];
    $postId = $data['Post']['id'];
    $postAgo = $data['Post']['post_ago'];
    $sharePic = $data['UserProfile']['image'];
    $gender = $data['UserProfile']['gender'];
    $fullName = $this->System->getFullNameById($data['Post']['user_id']);
    $userId = $this->Session->read('Auth.User')['id'];
    $myPost = $data['Post']['user_id'] === $userId ? true : false;
    
    $isLiked = $this->System->postReaction($postId, $userId, 'Like');
    $isCommented = $this->System->postReaction($postId, $userId, 'Comment');
    $isShared = $this->System->postReaction($postId, $userId, 'Post');
    
    $shareCount = $this->System->reactionCount($postId, 'Post');
    $commentCount = $this->System->reactionCount($postId, 'Comment');
    $likeCount = $this->System->reactionCount($postId, 'Like');

    $classListener = $data['Post']['deleted'] ? 'restore_post fas fa-recycle' : 'delete_post fa fa-trash';
    $title = $data['Post']['deleted'] ? 'Restore' : 'Delete';
?>
<div class='container border mt-5'>
    <div class='row p-3'>
        <div class="col-sm-2 p-2">
            <img src='<?=$sharePic;?>'>
        </div>
        <div class="post-details col-sm-10">
            <div class="row">
                <?php if($myPost):?>
                <div class='system-action-buttons col-sm-12'>
                    <button class='ml-2'>
                        <span href='<?=$this->Html->url(['controller' => 'posts', 'action' => 'edit', 'post_id' => $postId])?>' class='edit_post fa fa-edit float-right' data-toggle='tooltip' data-placement='top' title='Edit' type='button'></span> 
                    </button>
                    <button class=''>
                        <span href='<?=$this->Html->url(['controller' => 'posts', 'action' => 'delete', 'post_id' => $postId])?>' class='<?=$classListener?> float-right' data-toggle='tooltip' data-placement='top' title='<?=$title?>' type='button'></span> 
                    </button>
                </div>
                <?php endif;?>
                <div class="post-user"><a href='<?=$this->Html->url(['controller' => 'users', 'action' => 'profile', 'user_id' => $data['Post']['user_id']])?>'>
                    <?=$fullName?>
                </a></div>
                <div class="post-ago">
                    <?=$postAgo?>
                </div>
                <div class='post-content col-sm-12'>
                    <p>
                        <?=h($content)?>
                    </p>
                </div>
                <?php if($data['Post']['image']):?>
                    <div class='post-image col-sm-12 mb-2'>
                        <img src="/<?=$data['Post']['image']?>">
                    </div>
                <?php endif;?>
                <?php
                if($data['Post']['post_id']) {
                    $sharedPost =  $this->System->getSharedPost($data['Post']['post_id']);
                    $sharedFullName =  $this->System->getFullNameById($sharedPost['User']['id']);
                    $sharedProfile = $sharedPost['UserProfile']['image'];
                    $sharedPostAgo = $sharedPost['Post']['post_ago'];
                    $sharedContent = $sharedPost['Post']['content'];
                    
                    $sharePost = "<div class='share-post border p-3'>";
                   
                    $sharePost .= "   <div class='row'>
                                        <div class='post-img col-sm-2'>";
                    $sharePost .=     "<img src='$sharedProfile'>";
                    $sharePost .= "   </div>";

                    $sharePost .= "<div class='post-details col-sm-10'>
                                        <div class='row'>
                                            <div class='post-user'><a href='".$this->Html->url(['controller' => 'users', 'action' => 'profile', 'user_id' => $sharedPost['User']['id']])."'>"
                                                .$sharedFullName.
                                            "</a></div>
                                            <div class='post-ago'>
                                                $sharedPostAgo
                                            </div>
                                            <div class='post-content col-sm-12'>
                                                <p>".$sharedContent. "<p>
                                            </div>";
                            if($sharedPost['Post']['image']) {
                                $sharePost .="<div class='sharedpost-image col-sm-12'>
                                                <img src='/".$sharedPost['Post']['image']."'>
                                            </div>";
                            }
                    $sharePost .=       "</div>
                                        </div>
                                    </div>
                                </div>";
                                
                    echo $sharePost;
                }
                ?>
            </div>
        </div>
    </div>
    <div class='post-buttons border-top'>
        <div class='row'>
            <button href='<?=$this->Html->url(['controller' => 'comments', 'action' => 'add', 'post_id' => $postId])?>' postid='<?=$postId?>' class='comment_post col-sm-4'>
                <span class='<?= ($isCommented ? 'fas' : 'far') ?> fa-comment' data-toggle='tooltip' data-placement='top' title='Comment'> <?= (!empty($commentCount) ? $commentCount : '') ?></span>
            </button>
            <button href='<?=$this->Html->url(['controller' => 'likes', 'action' => 'add'])?>' class='like_post col-sm-4' postid='<?=$postId?>'>
                <span class='<?= ($isLiked ? 'fas' : 'far') ?> fa-heart' data-toggle='tooltip' data-placement='top' title='Like'> <?= (!empty($likeCount) ? $likeCount : '') ?></span>
            </button>
            <button href='<?=$this->Html->url(['controller' => 'posts', 'action' => 'share', 'post_id' => $postId])?>' class='share_post col-sm-4' postid='<?=$postId?>'>
                <span class='<?= ($isShared ? 'fas' : 'far') ?> fa-share-square' data-toggle='tooltip' data-placement='top' title='Share'> <?= (!empty($shareCount) ? $shareCount : '') ?></span>
            </button>
        </div>
    </div>
</div>
<?php
    if($comments) {
        $comment = '';
        foreach ($comments as $val) {
            $myComment = $val['Comment']['user_id'] === $userId ? true : false;
            
            $commenter = $this->System->getFullNameById($val['Comment']['user_id']);
            $commenterImg = $this->System->getUserPic($val['Comment']['user_id']);
            
            $commentAgo = $val['Comment']['comment_ago'];
            $commentId = $val['Comment']['id'];

            $commentClassListener = $val['Comment']['deleted'] ? 'restore_comment fas fa-recycle' : 'delete_comment fa fa-trash';
            $commentTitle = $val['Comment']['deleted'] ? 'Restore' : 'Delete';
            
            $commentButtons = '';
            
            if($myComment) {
                $commentButtons .= "<div class='system-action-buttons col-sm-12'>
                                        <button class='ml-2'>
                                            <span href='".$this->Html->url(['controller' => 'comments', 'action' => 'edit', 'id' => $commentId])."' class='edit_comment fa fa-edit' data-toggle='tooltip' data-placement='top' title='Edit' type='button'></span> 
                                        </button>
                                        <button class=''>
                                            <span href='".$this->Html->url(['controller' => 'comments', 'action' => 'delete', 'id' => $commentId])."' class='$commentClassListener' data-toggle='tooltip' data-placement='top' title='$commentTitle' type='button'></span> 
                                        </button>
                                    </div>";
            }
            
            $comment .= "<div class='container comments border'>";
            $userProfile = "<div class='row p-2'>";
            $userProfile .= "    <div class='p-2 m-2 col-sm-1'>
                                    <img src=' $commenterImg 'class='mx-auto'>
                                </div>";
            $userProfile .= "   <div class='row p-2 col-sm-11'>";
            $userProfile .= $commentButtons;
            $userProfile .= "       <div class='post-user'><a href='".$this->Html->url(['controller' => 'users', 'action' => 'profile', 'user_id' => $val['Comment']['user_id']])."'>
                                    $commenter
                                    </a></div>
                                    <div class='post-ago'>
                                        $commentAgo
                                    </div>
                                    ";
            $comment .= $userProfile;
            $commentContent =       "<div class='post-content col-sm-12'>
                                        <p>";
            $commentContent .=           $val['Comment']['content'];
            $commentContent .=         "</p>
                                     </div>";
            $commentContent .=   "</div>";
            $comment .= $commentContent;
            $comment .=     "</div>
                         </div>";
        }
        echo $comment;
        
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
    }
?>
<?php endif;?>