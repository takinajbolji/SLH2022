//za pretragu u tabeli 	

   function myFunction() {
  		var input, filter, table, tr, td, i, txtValue;
  		input = document.getElementById("myInput");
  		filter = input.value.toUpperCase();
  		table = document.getElementById("myTable");
      	tr = table.getElementsByTagName("tr");
      	for (i = 0; i < tr.length; i++) {
   			td = tr[i].getElementsByTagName("td")[0];
    		if (td) {
      			txtValue = td.textContent || td.innerText;
      			if (txtValue.toUpperCase().indexOf(filter) > -1) {
       				 tr[i].style.display = "";
      			} else {
       				 tr[i].style.display = "none";
      			}	
    		}       
  		}
	}

// za iskacuce obavestenje iznad teksta 
	
	$(document).ready(function(){
  	$('[data-toggle="popover"]').popover();   
	});
	

//pretrazivanje
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable td").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

