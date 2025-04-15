<label for="" >Upload Stock</label>
<input type="file" name="stock" class="form-control" required accept=".xls,.xlsx">

<span class="text-danger">{{ $errors->first('stock') }}</span> 