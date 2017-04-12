<?php 
use System\Libs\Auth;
?>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="admin/home">Kezdőoldal</a> 
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <span>Termékek listája</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- END PAGE HEADER-->

    <div class="margin-bottom-20"></div>

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">

                <!-- RÉSZLETEK MEGJELENÍTÉSE MODAL -->	
                <div class="modal" id="ajax_modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" id="modal_container"></div>
                    </div>
                </div>	
                <!-- RÉSZLETEK MEGJELENÍTÉSE MODAL END -->	

                <div id="ajax_message"></div> 						
                <!-- echo out the system feedback (error and success messages) -->
                <?php $this->renderFeedbackMessages(); ?>				

                <form class="horizontal-form" id="product_form" method="POST" action="">	

                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-shopping-cart"></i>Termékek listája</div>
                            <div class="actions">
                                <a href="admin/products/new_product" class="btn blue btn-sm"><i class="fa fa-plus"></i> Új termék</a>
                                <button class="btn red btn-sm" id="delete_group" type="button"><i class="fa fa-trash"></i> Csoportos törlés</button>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- *************************** JOBS TÁBLA *********************************** -->						
                            <table class="table table-striped table-bordered table-hover table-checkable dataTable" id="products">
                                <thead>
                                    <tr>
                                        <th class="table-checkbox">
                                            <input type="checkbox" class="group-checkable" data-set="#products .checkboxes"/>
                                        </th>
                                        <th style="width:105px">Kép</th>
                                        <th>Megnevezés</th>
                                        <th>Kategória</th>
                                        <th>Ár</th>
                                        <th>ÁFA kulcs</th>
                                        <th>Létrehozva</th>
                                        <th style="width:1%;">Státusz</th>
                                        <th style="width:1%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $upload_path = $this->getConfig('productphoto.upload_path');
                                        foreach ($all_products as $value) {
                                    ?>
                                        <tr class="odd gradeX">
                                            <td>
                                            <?php if (Auth::hasAccess('products.delete')) : ?>
                                                <input type="checkbox" class="checkboxes" name="product_id_<?php echo $value['product_id']; ?>" value="<?php echo $value['product_id']; ?>"/>
                                            <?php endif; ?>	
                                            </td>
                                            <td><img src="<?php echo $this->url_helper->thumbPath($upload_path . $value['product_photo']); ?>" class="img-responsive"/></td>
                                            <td><?php echo $value['product_title']; ?></td>
                                            <td><?php echo $value['product_category_name']; ?></td>
                                            <td><?php echo $value['product_price'] . ' Ft'; ?></td>
                                            <td><?php echo $value['product_tax'] . '%'; ?></td>

                                            <td><?php echo date('Y-m-d H:i', $value['product_create_timestamp']); ?></td>
                                            
                                            <?php if ($value['product_status'] == 1) { ?>
                                                <td><span class="label label-sm label-success">Aktív</span></td>
                                            <?php } ?>
                                            <?php if ($value['product_status'] == 0) { ?>
                                                <td><span class="label label-sm label-danger">Inaktív</span></td>
                                            <?php } ?>
                                            <?php if ($value['product_status'] == 2) { ?>
                                                <td><span class="label label-sm label-success">Kiemelt</span></td>
                                            <?php } ?>                                                
                                            <td>									
                                                <div class="actions">
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm grey-steel" href="#" data-toggle="dropdown">
                                                            <i class="fa fa-cogs"></i> 
                                                        </a>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li><a href="<?php echo $this->request->get_uri('site_url') . 'products/view_product/' . $value['product_id']; ?>"><i class="fa fa-eye"></i> Részletek</a></li>
                                                            <!-- <li><a href="javascript:void(0)" class="modal_trigger" rel="<?php //echo $value['product_id'];   ?>"><i class="fa fa-eye"></i> Részletek</a></li>	-->	

                                                            <?php if (Auth::hasAccess('products.update')) { ?>  
                                                                <li><a href="admin/products/update_product/<?php echo $value['product_id'];?>"><i class="fa fa-pencil"></i> Szerkeszt</a></li>
                                                            <?php } ?>

                                                            <?php if (Auth::hasAccess('products.delete')) { ?>
                                                                <li><a class="delete_item" data-id="<?php echo $value['product_id']; ?>"><i class="fa fa-trash"></i> Töröl</a></li>
                                                            <?php } ?>
                                               
                                                            <?php if (Auth::hasAccess('products.change_status')) { ?>   
                                                                <?php if ($value['product_status'] == 1) { ?>
                                                                    <li><a class="change_status" data-id="<?php echo $value['product_id']; ?>" data-action="make_inactive"><i class="fa fa-ban"></i> Blokkol</a></li>
                                                                <?php } ?>
                                                                <?php if ($value['product_status'] == 0) { ?>
                                                                    <li><a class="change_status" data-id="<?php echo $value['product_id']; ?>" data-action="make_active"><i class="fa fa-check"></i> Aktivál</a></li>
                                                                <?php } ?>
                                                            <?php } ?>  

                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>	
                                </tbody>
                            </table>	
                        </div> <!-- END PORTLET BODY -->
                    </div> <!-- END PORTLET -->

                </form>					

            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER-->    
</div>