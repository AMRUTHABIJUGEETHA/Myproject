@extends('layouts.app')
@section('main_content')
            
    @if ( Session::has('flash_message') )

        <div class="alert {{ Session::get('flash_type') }}">
            <h3>{{ Session::get('flash_message') }}</h3>
        </div>

    @endif
        <div style="margin:10px 50px 50px 50px;">
            <form action="/upload" class="dropzone" method="post" enctype="multipart/form-data">
                @csrf    
                    <div class="form-group" >
                        
                        <div id="dropzone" name="dropzone">
                            <!-- <input type="file" name="file"  multiple/> -->
                        </div> 
                    </div>
            </form>
        </div>

        <div style="margin:80px 50px 50px 50px;">
        
        <table id="filesTable" class="stripe" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Actions</th>
                    <th scope="col">File Name</th>
        
            
                </tr>
            </thead>
            <tbody>   
                <?php foreach($rec as $rows){ ?>
                    <?php if(Session::get('highlight') == $rows->id){ $class = "row_selected"; } ?>
                    <tr class="{{ @$class }}">
                        <th scope="col"><a href="{{url('delete/'.$rows->id)}}">Delete</a></th>
                        <th scope="col">{{$rows->file_name}}</th>
                    </tr>
                <?php } ?>              
            </tbody>
        </table>
                
</div>   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
<script>
$(document).ready( function () {
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var dataTable_url = "@php echo url('datalist'); ?>";          

    $('#filesTable').DataTable({
        "colReorder": false,  
    });
    // jQuery
    
    
    $("#dropzone").dropzone({
       type:'post',
        params: {_token:CSRF_TOKEN},
        url: "/upload",
        paramName: 'file',
        clickable: true,
        maxFilesize: 2000000,
        success:function(response){
            
        }
    });
});
</script> 

@endsection 