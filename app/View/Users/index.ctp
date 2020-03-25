<div class="container pt-4">
	<?= $this->Flash->render() ?>
    <div class="row">
        <div class="col-md-6">
            <p>
                <h1><center> Microblog 2 </center></h1>
            </p>
            <p>
                Praesent tincidunt dictum aliquet. Aliquam dapibus dui felis, dictum ullamcorper sapien malesuada vel. Duis suscipit felis sit amet massa posuere dapibus. Vivamus nec quam nunc. Vestibulum finibus libero sed nisl luctus consequat. Vestibulum eget magna nec augue pellentesque vehicula quis vitae mi. Vivamus quis dignissim lacus. Duis est nibh, luctus et mauris accumsan, pulvinar tempus enim. Mauris vitae pellentesque dui, sit amet tristique arcu. Vivamus lacus diam, molestie eget orci non, pulvinar luctus felis. Nullam et sagittis ante. In tortor lectus, volutpat at pharetra vel, accumsan sed libero.
            </p>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Register</div>
                    <div class="card-body card-block">
                        <form id="form_register" action="/users/register" method="post" class="form-modal" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nf-username" class="form-control-label">Username</label>
                                        <input type="text" id="nf-username" name="username" placeholder="Enter Username.." class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nf-password" class="form-control-label">Password</label>
                                        <input type="password" id="nf-password" name="password" placeholder="Enter Password.." class="form-control " required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nf-email" class="form-control-label">Email</label>
                                        <input type="text" id="nf-email" name="email" placeholder="Enter Email.." class="form-control" required>
                                    </div>
                                    <div class="form-group">
										<?php
											$options = ['' => 'Select Gender...', 0 => 'Female', 1 => 'Male'];
											echo $this->Form->input('nf-gender',
                                                                    ['type' => 'select',
                                                                     'class' => 'form-control',
                                                                     'options'=> $options,
                                                                     'label'=>['text'=>'Gender',
                                                                               'for' => 'nf-gender',
                                                                               'class'=>'form-control-label']
											]
										);
										?>
                                        <!-- <label for="nf-mobile_number" class="form-control-label">Mobile Number</label>
                                        <input type="number" id="nf-mobile_number" name="mobile_number" placeholder="Enter Mobile Number" class="form-control" required> -->
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nf-lastname" class="form-control-label">Last Name</label>
                                        <input type="text" id="nf-lastname" name="lastname" placeholder="Enter Last Name.." class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nf-firstname" class="form-control-label">First Name</label>
                                        <input type="text" id="nf-firstname" name="firstname" placeholder="Enter First Name.." class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nf-middlename" class="form-control-label">Middle Name</label>
                                        <input  type="text" id="nf-middlename" name="middlename" placeholder="Enter Middle Name.." class="form-control">
                                    </div> 
                                    <div class="form-group">
                                        <label for="nf-suffix" class="form-control-label">Suffix</label>
                                        <input  type="text" id="nf-suffix" name="suffix" placeholder="Enter Suffix.." class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mt-3">
                                        <button type="submit" class="register_user btn btn-primary form-control">
                                            <i class="fas fa-dot-circle"></i> Register
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>