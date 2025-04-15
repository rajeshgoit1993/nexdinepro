  <script>
//dsr_rsc_mtd
$(document).on("click",".dsr_rsc_mtd",function(){
    var outlet=$("#outlet").val();
    var start_date=$("#start_date").val();
    var end_date=$("#end_date").val();
    var city=$("#city").val();
    var region=$("#region").val()
    const date1 = new Date(start_date);
    const date2 = new Date(end_date);
    const diffTime = Math.abs(date2 - date1);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    if(diffDays>10 && outlet==0)
    {
      alert('Date range should be less than equal to 10 days when you select all outlet')
    }
   else
   {


   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "getdsr_rsc_mtd";
  
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="outlet"
    element1.value = outlet;
    element1.type = 'hidden'
    form.appendChild(element1);
    
    var element2 = document.createElement("INPUT");         
    element2.name="start_date"
    element2.value = start_date;
    element2.type = 'hidden'
    form.appendChild(element2);

      var element4 = document.createElement("INPUT");         
    element4.name="city"
    element4.value = city;
    element4.type = 'hidden'
    form.appendChild(element4);

     var element5 = document.createElement("INPUT");         
    element5.name="region"
    element5.value = region;
    element5.type = 'hidden'
    form.appendChild(element5);
    
    var element3 = document.createElement("INPUT");         
    element3.name="end_date"
    element3.value = end_date;
    element3.type = 'hidden'
    form.appendChild(element3);
    form.submit();
    }
  })
</script>