class ClassTemoignage {
  static publie(obj, idTemoignage) {
    $.ajax({
      url: "gestionTemoignage.php",
      data: "fct=publie&idTemoignage=" + idTemoignage,
      type: "post",
      success: function (myObj) {
        var objInput = obj.getElementsByTagName("INPUT");
        if (objInput) objInput[0].checked = myObj.is_publie ? true : false;
      },
    });
  }
  static interdit(obj, idTemoignage) {
    $.ajax({
      url: "gestionTemoignage.php",
      data: "fct=interdit&idTemoignage=" + idTemoignage,
      type: "post",
      success: function (myObj) {
        var objInput = obj.getElementsByTagName("INPUT");
        if (objInput) objInput[0].checked = myObj.is_interdit ? true : false;
      },
    });
  }
  static change(obj, idTemoignage) {
    $.ajax({
      url: "gestionTemoignage.php",
      data: "fct=change&idTemoignage=" + idTemoignage,
      type: "post",
      success: function (myObj) {
        document.getElementById("idCommentaire").innerHTML = myObj.commentaire;
      },
    });
  }
}
