<?= $this->element('postform'); ?>
<?php
    $paginator = $this->Paginator;
?>
<?php
    $article = '';
    if($data) {
        foreach ($data as $key => $value) {
            $gender = $value['UserProfile']['gender'];
            $profilePic = $value['UserProfile']['image'];
            $postAgo = $value['Post']['post_ago'];
            $postId = $value['Post']['id'];
            $postUserId = $value['Post']['user_id'];
            $postFullName = $this->System->getFullNameById($postUserId);
            $userId = $this->Session->read('User')['id'];
            $myPost = $postUserId === $userId ? true : false ;
            
            $isLiked = $this->System->postReaction($postId, $userId, 'Like');
            $isCommented = $this->System->postReaction($postId, $userId, 'Comment');
            $isShared = $this->System->postReaction($postId, $userId, 'Share');
            
            $likeCount = $this->System->reactionCount($postId, 'Like');
            $commentCount = $this->System->reactionCount($postId, 'Comment');
            $shareCount = $this->System->getPostCount($postId);
            
            $article .= "<div class='post-container border'>";
            $article .= "   <div class='row'>
                                <div class='post-img col-sm-2'>";
            $article .=     "<img src='$profilePic'>";
            $article .= "   </div>";
    
            $article .= "<div class='post-details col-sm-10'>
                            <div class='row'>";
                            if($myPost) {
                                
                            $article .= "<div class='system-action-buttons col-sm-12'>
                                            <button class='ml-2' style='float: right;'>
                                                <span href='".$this->Html->url(['controller' => 'posts', 'action' => 'edit', 'post_id' => $postId])."' class='edit_post fa fa-edit float-right' data-toggle='tooltip' data-placement='top' title='Edit' type='button'></span> 
                                            </button>
                                            <button class='' style='float: right;'>
                                                <span href='".$this->Html->url(['controller' => 'posts', 'action' => 'delete', 'post_id' => $postId])."' class='delete_post fa fa-trash float-right' data-toggle='tooltip' data-placement='top' title='Delete' type='button'></span> 
                                            </button>
                                        </div>";
                            }
            $article .=         "<div class='post-user'><a href='".$this->Html->url(['controller' => 'users', 'action' => 'profile', 'user_id' => $postUserId])."'>"
                                    .$postFullName.
                                "</a></div>
                                <div class='post-ago'>
                                    $postAgo
                                </div>
                                <div class='post-content col-sm-12'>
                                    <p>".h($value['Post']['content'], false). "<p>
                                </div>";
                                if($value['Post']['image']) {
                                    $article .=  "<div class='post-image col-sm-12 mb-2'>
                                                    <img src='/".$value['Post']['image']."'>
                                                </div>";
                                }
    
                        if($value['Post']['post_id']) {
                            $sharedPost =  $this->System->getSharedPost($value['Post']['post_id']);
                            if($sharedPost) {
                                $sharedProfile = $sharedPost['UserProfile']['image'];
                                $sharedFullName =  $this->System->getFullNameById($sharedPost['Post']['user_id']);
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
                                                        </div>";
                                                        if($sharedPost['Post']['image']) {
                                                            $sharePost .=  "<div class='sharedpost-image col-sm-12 mb-2'>
                                                                            <img src='/".$sharedPost['Post']['image']."'>
                                                                        </div>";
                                                        }
                                $sharePost .=       "</div>
                                                </div>
                                            </div>
                                        </div>";
                            } else {
                                $sharePost = "<div class='share-post border p-3 m-2'>";
                                $sharePost .= "<span><h4> Post Deleted </h4></span>";
                                $sharePost .= "</div>";
                            }
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
    }
?>