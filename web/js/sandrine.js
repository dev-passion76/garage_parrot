function controleSaisieUser(type) {
  if (event instanceof KeyboardEvent) {
    // it is a keyboard event!
    if (event.ctrlKey) return true;

    var oTarget = event.target ? event.target : event.srcElement;
    var maxLength = oTarget.maxLength;
    var start = oTarget.selectionStart;
    var end = oTarget.selectionEnd;

    if (
      type == 5 &&
      event.key.length == 1 &&
      ((event.key >= "a" && event.key <= "z") ||
        (event.key >= "A" && event.key <= "Z")) &&
      (maxLength == -1 || oTarget.value.length < maxLength || end - start > 0)
    ) {
      remplaceSaisiePar(event.key.toUpperCase(), event, oTarget);
      return false;
    } else if (
      type == 4 &&
      (event.code == "NumpadDecimal" ||
        event.code == "KeyM" ||
        event.code == "Comma") &&
      (maxLength == -1 || oTarget.value.length < maxLength || end - start > 0)
    ) {
      remplaceSaisiePar(".", event, oTarget);
      return false;
    }
    // NE PAS METTRE DE ELSE
    if (
      ((event.code.startsWith("Digit") && event.code.length == 6) ||
        (event.code.startsWith("Numpad") && event.code.length == 7)) &&
      (maxLength == -1 || oTarget.value.length < maxLength || end - start > 0)
    ) {
      var codeKey = event.code.substr(event.code.length - 1);

      remplaceSaisiePar(codeKey, event, oTarget);
      return false;
    }

    var key = event.key;
    if (
      (((key >= "0" && key <= "9") ||
        key == "/" ||
        key == ":" ||
        (key == ":" && type == 3) ||
        ((key == "A" || key == "B" || key == "a" || key == "b") &&
          start == 6 &&
          type == 2)) &&
        (maxLength == -1 ||
          oTarget.value.length < maxLength ||
          end - start > 0)) ||
      [
        "Delete",
        "ArrowLeft",
        "ArrowRight",
        "Backspace",
        "Enter",
        "Tab",
      ].includes(key)
    )
      return true;
  }
  return false;
}

function remplaceSaisiePar(codeKey, event, oTarget) {
  var start = oTarget.selectionStart;
  var end = oTarget.selectionEnd;
  var oldValue = oTarget.value;

  // replace point and change input value
  var newValue = oldValue.slice(0, start) + codeKey + oldValue.slice(end);
  oTarget.value = newValue;

  // replace cursor
  oTarget.selectionStart = oTarget.selectionEnd = start + 1;

  event.preventDefault();
}

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

class ClassHoraire {
  static phpCall = "horaire.php";

  static ouvertFerme(obj, jourSemaaine) {
    $.ajax({
      url: this.phpCall,
      data: "fct=ouverture&jourSemaaine=" + jourSemaaine,
      type: "post",
      success: function (myObj) {
        var objInput = obj.getElementsByTagName("INPUT");
        if (objInput) objInput[0].checked = myObj.is_ouvert ? true : false;
      },
    });
  }

  static modifieHoraire(objHtml, jourSemaaine) {
    $.ajax({
      url: this.phpCall,
      data:
        "fct=modifieHoraire&jourSemaaine=" +
        jourSemaaine +
        "&zone=" +
        // La fonction encodeURIComponent() permet d'encoder un composant d'un Uniform Resource Identifier (URI) en remplaçant chaque exemplaire de certains caractères
        encodeURIComponent(objHtml.name) +
        "&value=" +
        encodeURIComponent(objHtml.value),
      type: "post",
      success: function (objJsonRetour) {
        if (objJsonRetour.ok == 0) {
          // Comme le retour JSON est en fonction du nommage de la colonne, elle doit donc être reprise en mode dynamique donc utilisation de obj[<nom de la colone>]
          objHtml.value = objJsonRetour[objHtml.name];
          //alert(objJsonRetour.errorMessage);
        }
      },
    });
  }
}

class ClassWorkFlow {
  static changeStatut(obj, idxVehicule) {
    $.ajax({
      url: "vehicule.php",
      data:
        "fct=changeStatut&idxVehicule=" + idxVehicule + "&statut=" + obj.value,
      type: "post",
      success: function (myObj) {},
    });
  }
}
