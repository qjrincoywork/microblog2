<?php
    $content = $data['Post']['content'];
    $id = $data['Post']['id'];
    $postAgo = $data['Post']['post_ago'];
    $profPic = $data['UserProfile']['image'];
    $userId = $this->Session->read('User')['id'];
    $postImage = $data['Post']['image'] ? "/".$data['Post']['image'] : '';
    $fullName = $this->System->getFullNameById($userId);
?>
<div class="container p-3">
    <?= $this->Form->create('Post',
                            ['url' => ['controller' =>'posts', 'action' => 'edit']],
                            ['inputDefaults'=> ['div' => 'form-group']]); ?>
    <?php
        // $this->Form->unlockField('id');
        
        echo $this->Form->hidden('id', array(
                                'label' => false,
                                'value' => $id,
                                'id' => 'id'
        ));

        echo $this->Form->input('content', array(
                                'id' => 'content',
                                'value' => $content,
                                'label' => false,
                                'class' => 'mb-3 form-control ',
                                'placeholder' => "Edit Content..."
        ));
    ?>
    
    <?= $this->Form->input('image',
                        ['class' => 'image_input form-control',
                        'id' => 'image',
                        'type' => 'file',
                        "accept" => ".jpeg, .jpg, .png, .gif",
                        'style' => 'display: none;',
                        'label' => false,
                        'value' => $data['Post']['image']]);?>

    <div class="preview-image form-group">
        <label for="image" class="form-control-label"></label>
        <img class="img-upload" src="<?=$postImage?>">
    </div>
    
    <div class='container border p-3 mt-2'>
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
    <button class="edit_preview_image far fa-image" data-toggle='tooltip' data-placement='top' title='change image' style="float: left; font-size: 30px; color: #4c82a3;">
    </button>
    <?= $this->Form->end(['label' => 'edit post',
                            'class' => 'edit_post btn btn-primary',
                            'div' => 'form-group mt-3',
                            'style' => 'float: right']); ?>
</div>