   <input type="hidden" name="brand" id="brand" value="0">

<!--    <div class="col-md-10">

 <select name="brand" id="brand" class="form-control valid" required>
   
     <?php  
$brands=DB::table('brands')->get();
     ?>
     <option value="0" selected>All</option>
     @foreach($brands as $brand)
     <option value="{{ $brand->id }}">{{ $brand->brand }}</option>
     @endforeach
     </select >

      </div>
    

      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find</button>

        </div> -->



<div class="col-lg-6">
 <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Franchise </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body first_result_data">
                <canvas id="franchise_chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
              <p >Total: <span class="franchise_total"></span></p>
            </div>
</div>

<div class="col-lg-6">
 <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Products </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body products_result_data">
                <canvas id="products_chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
              <p>Total: <span class="product_total"></span></p>
            </div>
</div>