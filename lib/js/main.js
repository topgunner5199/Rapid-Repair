
$(document).ready(function(){

  $('.footable').footable();

  

  $("div.variableFields input[type=number]").bind('keyup mouseup', function () {
    if($(this).val() != ""){
      if($(this).parent().attr('id') == "Parts"){
          $("#Parts .fieldReplica").html("");
          var output = "";
          for(var i = 0; i < $(this).val(); i++){
            output += "<input type='hidden' name='numParts' value='"+$(this).val()+"'/>";
            output += '<label>Part '+(i+1)+" Name: </label> <select class='combobox additionalparts' name='partname"+i+"' required>";
            output += $("#PartValues").html()+"</select><br>"; 
            
          }
          $("#Parts .fieldReplica").html($("#Parts .fieldReplica").html()+output);
      }else if($(this).parent().attr('id') == "PromoParts"){
          $("#PromoParts .fieldReplica").html(" ");
          var output = " ";
          for(var i = 0; i < $(this).val(); i++){
            output += "<input type='hidden' name='numParts' value='"+$(this).val()+"'/>";
            output += '<label>Part '+(i+1)+" Name: </label> <select class='combobox additionalparts' name='partname"+i+"' required>";
            output += $("#PartValues").html()+"</select><br><label>Part Discount "+(i+1)+" Description</label><input type='text' name='partDescription"+i+"'/><br>"; 
            
          }
          $("#PromoParts .fieldReplica").html(output);
      }else if($(this).parent().attr('id') == "Packages"){
          $("#Packages .fieldReplica").html("");
          var output = "";
          for(var i = 0; i < $(this).val(); i++){
            output += "<input type='hidden' name='numPackages' value='"+$(this).val()+"'/>";
            output += '<label>Package '+(i+1)+" Name: </label> <select class='combobox additionalpackage' name='packagename"+i+"' required>";
            output += $("#PackageValues").html()+"</select><br><label>Package Discount "+(i+1)+" Description</label><input type='text' name='packageDescription"+i+"'/><br>"; 
            
          }
          $("#Packages .fieldReplica").html(output);
        
      }  
    }
    

    
               
    });
  });

/*$("div.variableFields input[type=number]").bind('keyup mouseup', function () {
    if($(this).val() != ""){
      if($(this).parent().attr('id') == "Part"){
        $("#Parts .fieldReplica").html("");
        for(var i = 0; i < $(this).val(); i++){
          var output = '<div class="ui-widget"><label>Part '+(i+1)+" Name: </label> <select class='combobox additionalparts' name='partname"+i+"'>";
          output += $("#PartValues").html()+"</select>"; 
          $("#Parts .fieldReplica").html($("#Parts .fieldReplica").html()+output);
          $( ".additionalparts" ).combobox();
        }
        
      }
    }

    
               
  });*/
