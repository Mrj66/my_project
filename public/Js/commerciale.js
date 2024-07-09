document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('dateInput');
    const weekNumberInput = document.getElementById('weekNumber');

    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];

    dateInput.value = formattedDate;

    weekNumberInput.value = getISOWeekNumber(today);

    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        weekNumberInput.value = getISOWeekNumber(selectedDate);
    });

    function getISOWeekNumber(date) {
        const tempDate = new Date(date.getTime());
        const dayNum = tempDate.getUTCDay() || 7;
        tempDate.setUTCDate(tempDate.getUTCDate() + 4 - dayNum);
        const yearStart = new Date(Date.UTC(tempDate.getUTCFullYear(),0,1));
        const weekNum = Math.ceil((((tempDate - yearStart) / 86400000) + 1) / 7);
        return weekNum;
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const addButton = document.getElementById('add');
    const inputTableBody = document.querySelector('#table tbody');

    addButton.addEventListener('click', function () {
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input class="form-control" type="text" name="entreprise_visitees"></td>
            <td>
                <select class="form-select" size="1" name="type_visite">
                    <option value="0">Veuillez choisir</option>
                    <option value="visio">Visio</option>
                    <option value="presentiel">Présentiel</option>
                    <option value="telephone">Téléphone</option>
                </select>
            </td>
            <td><input class="form-control" type="text" name="principal_interlocuteur"></td>
            <td><input class="form-control" type="text" name="objectif_objet_motif"></td>
            <td><input type="checkbox" class="form-check-input chasser" name="chasser"></td>
            <td><input type="checkbox" class="form-check-input reseauter" name="reseauter"></td>
            <td><input type="checkbox" class="form-check-input actualiser" name="actualiser"></td>
            <td><input type="checkbox" class="form-check-input fideliser" name="fideliser"></td>
        `;

        inputTableBody.appendChild(newRow);
    });
});

document.getElementById('non').addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('textareaNon').style.display = 'block';
    } else {
        document.getElementById('textareaNon').style.display = 'none';
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const button = document.getElementById('prevue');
    const inputTable = document.querySelector('#Prospection tbody');

    button.addEventListener('click', function () {
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input class="form-control" type="text" name="entreprise_visitees"></td>
            <td>
                <select class="form-select" size="1" name="type_visite">
                    <option value="0">Veuillez choisir</option>
                    <option value="visio">Visio</option>
                    <option value="presentiel">Présentiel</option>
                    <option value="telephone">Téléphone</option>
                </select>
            </td>
            <td><input class="form-control" type="text" name="principal_interlocuteur"></td>
            <td><input class="form-control" type="text" name="objectif_objet_motif"></td>
            <td><input type="checkbox" class="form-check-input chasser" name="chasser"></td>
            <td><input type="checkbox" class="form-check-input reseauter" name="reseauter"></td>
            <td><input type="checkbox" class="form-check-input actualiser" name="actualiser"></td>
            <td><input type="checkbox" class="form-check-input fideliser" name="fideliser"></td>
        `;

        inputTable.appendChild(newRow);
    });
});

function réinitialiser() {
    if(window.confirm("Êtes-vous sûr de vouloir tout effacer? Toutes les données saisies seront perdues.")){
        return true;
    }
    else{
        return false;
    }
}