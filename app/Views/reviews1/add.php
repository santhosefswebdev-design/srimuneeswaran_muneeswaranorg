<?php global $lang; ?>
<style>
.ui-autocomplete{
            padding: 0px !important;
    }
    .ui-autocomplete ul{
        background-color: #5d8dff; font-size:14px;
    }
    li a{
        color: #fff;
    }

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

    <?php if(empty($data['image'])) {?>
        #img_pre {
            display : none;
        }
    <?php }
	if($view == true) { ?>
        label.form-label span { display:none !important; color:transporant; }
    <?php } ?>
        
</style>

<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> News and Events / Add</h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Add Archanai Settings</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/news_events"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/news_events/save" method="POST" enctype='multipart/form-data'>
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="name"  class="form-control" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> required>
                                        <label class="form-label">Title <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="description"  class="form-control" value="<?php echo $data['description'];?>" <?php echo $readonly; ?> required>
                                        <label class="form-label">Description <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            
                            
                           
                           
                            
                            
                          
                            </div>
                            <div class="row">
                            <?php if($view != true) { ?>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label" style="display: contents;">Image</label>
                                        <input type="file" id="imgInp" name="image" accept="image/png,image/jpeg,image/jpg" class="form-control" multiple <?php echo $readonly; ?>>
                                        <!--<label class="form-label">Image</label>-->
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="">
											<?php if(!empty($data['image'])) {?>
                                                <a target="_blank" href="/uploads/reviews1/<?php echo $data['image']; ?>">
                                                    <img id="img_pre" src="/uploads/reviews1/<?php echo $data['image']; ?>" width="200" height="160"></img>
                                                </a>
											<?php } else { ?> 
												
												<!--<a id="img_anchor" target="_blank" href="#"> -->
                                                    <img id="img_pre" src="#" width="200" height="160"></img>
                                                <!--</a>  -->
											<?php }?>												
                                            </div>
                                        </div>
                            </div> 
                           
                        </div>

                        
                    </div>
                    </div>
                    
                    <?php if($view != true) { ?>
                    <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                        <input type="submit" id="submit" class="btn btn-success btn-lg waves-effect" value="SAVE">
                        <button type="reset" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                    </div>
                    <?php } ?>
                    </form>
                    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body p-4">
                                        <div class="text-center">
                                            <i class="dripicons-information h1 text-info"></i>
                                            <table>
                                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                                             </table>
                                            
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section> 

<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<?php if($data['view_archanai'] != 0) {?>
<script>
    $('#alpha').prop('checked', false);
    //$('#alpha_stock').prop('checked', false);
</script>
<?php } ?>
<script>
    $(document).ready(function(){
    $('#amount, #com_per').on('blur', commission_amount);
});

function commission_amount(){
	var com_per = ($('#com_per').val() != '') ? $('#com_per').val() : 0;
	var amount = ($('#amount').val() != '') ? $('#amount').val() : 0;
	var com_amount = amount * (com_per/100);
	$('#commission').val(com_amount.toFixed(2));
}
    $("#clear").click(function(){
		
       $("input").val("");
    });
    
    function addCategory() 
	{
		$('.custom-category-modal').modal();
	}
		
		$("#imgInp").change(function(){
			// alert (0);
        readURL(this);		
		});
		
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				
				reader.onload = function (e) {
					//alert (URL.createObjectURL(e.target.files[0]))
					$('#img_pre').attr('src', e.target.result);
					$('#img_pre').show();
					//$('#img_anchor').attr("href", e.target.result)				
				}            
				reader.readAsDataURL(input.files[0]);
			}
		}
function validations(){
    $.ajax
        ({
        type:"POST",
        url: "<?php echo base_url(); ?>/master/archanai_validation",
        data: $("form").serialize(),
        success:function(data)
        {
            obj = jQuery.parseJSON(data);
            console.log(obj);
            if(obj.err != ''){
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text(obj.err);
            }else{
                $("#loader").show();
                $("form").submit();
            }
        }
    })
        
}
</script>
<script type="text/javascript">

$("#groupname").autocomplete({
	source: function( request, response ) {
		$.ajax({
			url: "<?php echo base_url(); ?>/archanai/get_group",
			type: 'post',
			data: { search: request.term},
			dataType: 'json',
			success: function(data){
				response(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				console.log("error handler!");
			}
		});
	},
	minLength: 1,
	select: function( event, ui ) {
		console.log("Selected: "+ui.item.name);
	}
}); 
$("form").on("submit", function(){
    $("#loader").show();
});
  </script>