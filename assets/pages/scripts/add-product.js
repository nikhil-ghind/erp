jQuery(document).ready(function() {
   $("#category_id").select2({
      placeholder:"Select the category",
      
   });
   $("#supplier_id").select2({
      placeholder:"Select the list of suppliers",
      
      multiple:true,
      
   });
});