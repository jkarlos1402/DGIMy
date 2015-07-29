function sendNotification(idSol, idUsu, estatusSol, idObr, idRolUsu, idBco, estatusBco, numDictamen) {    
    if (typeof (idSol) !== "undefined" && typeof (idUsu) !== "undefined" &&
            typeof (estatusSol) !== "undefined" && typeof (idObr) !== "undefined" &&
            typeof (idRolUsu) !== "undefined" && typeof (idBco) !== "undefined" &&
            typeof (estatusBco) !== "undefined" && typeof(numDictamen) !== "undefined"){  
        console.log("notificacion");
        $.ajax({            
                url: 'http://192.168.20.7:8082/SGIApp-war/serv/notificacion',
            data: {
                idSol: idSol,
                idUsu: idUsu,
                estatusSol: estatusSol,
                idObr: idObr,
                idRolUsu: idRolUsu,
                idBco: idBco,
                estatusBco: estatusBco,
                numDictamen: numDictamen
            },
            type: 'POST',
            crossDomain: true
        });
    }
}

