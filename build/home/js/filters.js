(function () {

  angular.module('failboxStore.filters', [])
    .filter('urlName', function () {
      return function (inputname) {
        inputname = inputname.trim();
        var no_permitidas = ["á","é","í","ó","ú","Á","É","Í","Ó","Ú","Ñ","ñ","&","(",")","+","/"];
        var permitidas = ["a","e","i","o","u","A","E","I","O","U","N","n"," "," "," "," "," "];
        var convert_name = inputname.split(" ");
        convert_name = convert_name.join('-');
        convert_name = convert_name.toLowerCase();
        var auxArray = convert_name.split("");
        for(var i = 0; i<auxArray.length; i++){
          var result = no_permitidas.indexOf(auxArray[i]);
          if(result!=-1){
            auxArray[i] = permitidas[result];
          }
        }
        convert_name = auxArray.join("");
        return convert_name;
      };
    })
})();
