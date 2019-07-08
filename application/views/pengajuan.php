<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengajuan
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Beranda</a> -> Pengajuan</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="widget-box widget-color-orange" id="widget-box-3">
            <div class="widget-body">
              <div class="widget-main">
                <div class="row">
                  <div class="col-md-12">

                    <div class="pull-left">
                      <div class="btn-group">
                        <!-- Btn Add User -->
                        <button class="btn btn-white btn-info btn-bold" data-toggle="modal" data-target="#myModal">
                          <i class="ace-icon fa fa-plus bigger-120 blue"></i>Add
                        </button>
                        
                        <!-- Btn Refresh Page -->
                        <a href="<?php echo site_url('text')?>" class="btn btn-white btn-success btn-bold tooltip-success" data-rel="tooltip" data-placement="top" title="Refresh Page">
                          <i class="fa fa-refresh"></i>
                        </a>
                        

                        <!-- Modal Add User-->
                        <div class="modal fade" id="myModal" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><b>#Add Text</b></h4>
                              </div>
                              <div class="modal-body">
                                <?php echo form_open("text/input");?>
                                <div class="box-body">
                                  <div class="form-group">
                                    <label>Text Title</label>
                                    <color class="text-red"> *</color>
                                    <input type="text" class="form-control" placeholder="Text Title" name="text_title" required="required">
                                  </div>
                                  <div class="form-group">
                                    <label>Text Description</label>
                                    <color class="text-red"> *</color>
                                    <textarea name="text_description" class="form-control" placeholder="Text Description" rows="4"></textarea>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                                <?php echo form_close(); ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Of Modal -->

                      </div>
                    </div>

                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <hr>
                    <div class="pull-left">
                      <div class="btn-group">
                        <!-- Combo Limit Rows Table -->
                        <select class="form-control" id="getrows" onchange="getrows(this.value)">
                          <option value="">rows</option>
                          <?php $rw=array(1=>5, 10, 25, 50, 100);
                            for($i=1;$i<=count($rw);$i++) {
                              if($rw[$i]==$this->uri->segment(3)) {
                                echo "<option value='$rw[$i]' selected/>$rw[$i]</option>";
                              } else {
                                echo "<option value='$rw[$i]'/>$rw[$i]</option>";
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="pull-right">
                      <!-- Form Search -->
                      <?php echo form_open("text/result", "class='form-inline'");?>
                      <div class="btn-group">
                        <select class=" form-control input-large" name="column_name">
                          <option value="">Search by</option>
                          <?php
                            foreach ($column as $c) {
                              $col      = explode('_',$c->COLUMN_NAME);
                              $theName  = strtoupper($col[0].$col[1]);
                              if($c->COLUMN_NAME==$this->session->userdata('sess_cari_text2')){
                          ?>
                          <option value="<?php echo $c->COLUMN_NAME;?>" selected><?php echo $theName;?></option>
                          <?php }else{?>
                          <option value="<?php echo $c->COLUMN_NAME;?>"><?php echo $theName;?></option>
                          <?php }} ?>
                        </select>

                        <?php if($this->session->userdata('sess_cari_text')){?>
                        <input type="text" class="form-control" placeholder="Search..." name="key" value="<?php echo $this->session->userdata('sess_cari_text')?>" />
                        <?php } else{ ?>
                        <input type="text" class="form-control" placeholder="Search..." name="key" />
                        <?php } ?>
                      </div>
                      <button class="btn btn-white btn-info btn-bold">
                        <i class="ace-icon fa fa-search bigger-120 blue"></i>Search
                      </button>
                      <?php echo form_close();?>
                      <!-- End Form Search -->
                    </div>
                  </div>
                </div>
                <br>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                      <tr>
                        <th>No</th>
                        <th>Text Title</th>
                        <th>Text Description</th>
                        <th>#</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if($this->uri->segment(2)=="index"){
                          $no=1+$this->uri->segment(4);
                        }else{
                          $no=1+$this->uri->segment(5);
                        }
                        
                        if($text){
                        foreach ($text as $key){
                          $id=$key->text_id;
                      ?>
                      <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $key->text_title?></td>
                        <td><?php echo $key->text_description?></td>
                        <td>
                          <button class="btn btn-white btn-info btn-bold btn-xs" data-toggle="modal" data-target="#editModal<?php echo $id;?>">
                            <i class="ace-icon fa fa-edit bigger-120 blue"></i>
                          </button>
                          <button class="btn btn-white btn-danger btn-bold btn-xs" data-toggle="modal" data-target="#deleteModal<?php echo $id?>">
                            <i class="ace-icon fa fa-trash bigger-120 red"></i>
                          </button>
                        </td>
                      </tr>
                      <!-- Modal Edit-->
                      <div class="modal fade" id="editModal<?php echo $id?>" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><b>#Edit Text</b></h4>
                            </div>
                            <div class="modal-body">
                              <?php echo form_open("text/edit");?>
                              <div class="box-body">
                                <div class="form-group">
                                  <label>Text Title</label>
                                  <color class="text-red"> *</color>
                                  <input type="text" class="form-control" placeholder="Text Title" name="text_title" required="required" value="<?php echo $key->text_title?>">
                                  <input type="hidden" class="form-control" placeholder="Text ID" name="text_id" required="required" value="<?php echo $key->text_id?>">
                                </div>
                                <div class="form-group">
                                  <label>Text Description</label>
                                  <color class="text-red"> *</color>
                                  <textarea name="text_description" class="form-control" placeholder="Text Description" rows="4"><?php echo $key->text_description?></textarea>
                                </div>
                              </div>
                              <!-- /.box-body -->
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Edit</button>
                              </div>
                              <!-- /.box-footer -->
                              <?php echo form_close(); ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Modal Delete-->
                      <div class="modal fade" id="deleteModal<?php echo $id;?>" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <?php echo form_open("text/delete");?>
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">#Delete Text</h4>
                            </div>
                            <div class="modal-body">
                              <div class="alert alert-danger">Are you sure want delete "<b><?php echo $key->text_title?></b>" running text?</div>
                            </div>
                            <div class="modal-footer">
                              <input type="hidden" class="form-control" value="<?php echo $key->text_id?>" name="text_id" required="required">
                              <button type="submit" class="btn btn-danger">Ya</button>
                              <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                            </div>
                            <?php echo form_close(); ?>
                          </div>
                        </div>
                      </div>
                      <?php
                          $no++;
                          }
                        
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
                <!-- Tampilkan Pagging -->
                <?php echo $links;?>

                <!-- Get Limit Rows using ajax -->
                <script type="text/javascript">
                  function getrows(angka){
                    var product_code = angka;
                    console.log(product_code);
                    $.ajax({
                      success:function(){
                        <?php if($this->uri->segment(2)=='result'){ ?>
                            location.href='<?php echo base_url()?>index.php/text/result/'+angka;    
                        <?php  }else{ ?>
                            location.href='<?php echo base_url()?>index.php/text/index/'+angka;    
                        <?php } ?> 
                      }
                    });
                  }
                </script>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->