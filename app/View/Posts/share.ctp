<?php
    $content = $data['Post']['content'];
    $postId = isset($data['Post']['post_id']) ? $data['Post']['post_id'] : $data['Post']['id'];
    $postAgo = $data['Post']['post_ago'];
    $profPic = $data['UserProfile']['image'];
    $fullName = $this->System->getFullNameById($data['User']['id']);
?>
<div class="container p-3">
    <?= $this->Form->create('Post',
                            ['url' => ['controller' =>'posts', 'action' => 'share']],
                            ['inputDefaults'=> ['div' => 'form-group']]); ?>
    <?php
        echo $this->Form->input('content', array(
                                'label' => false,
                                'id' => 'content',
                                'class' => 'mb-3 form-control ',
                                'placeholder' => "Add Content..."
        ));
        echo $this->Form->input('post_id', array(
                                'label' => false,
                                'type' => 'hidden',
                                'value' => $postId,
                                'id' => 'post_id'
        ));
    ?>
    <div class='container border p-3'>
        <div class='row'>
            <div class="col-sm-2">
                <img src='<?=$profPic;?>'>
            </div>
            <div class="post-details col-sm-10">
                <div class="row">
                    <div class="post-user">
                        <?=$fullName?>
                    </div>
                    <div class="post-ago">
                        <?=$postAgo?>
                    </div>
                    <div class='post-content col-sm-12'>
                        <p>
                            <?=h($content)?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end(['label' => 'share',
                            'class' => 'share_post btn btn-primary form',
                            'div' => 'form-group mt-3',
                            'style' => 'float: right']); ?>
</div>