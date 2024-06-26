document.addEventListener("DOMContentLoaded", function () {
    const signaturePads = document.querySelectorAll(".signature-pad");

    signaturePads.forEach(signaturePad => {
        const svg = signaturePad.querySelector(".signature-svg");
        const clearButton = signaturePad.querySelector(".clear-button");

        if (!svg || !(svg instanceof SVGElement)) {
            console.error("svg n'est pas trouvable.");
            return;
        }

        let drawing = false;
        let currentPath;

        function startDrawing(event) {
            drawing = true;
            const point = getPosition(event, svg);
            currentPath = createPath(point);
            svg.appendChild(currentPath);
            event.preventDefault(); 
        }

        function draw(event) {
            if (!drawing) return;
            const point = getPosition(event, svg);
            addPointToPath(currentPath, point);
            event.preventDefault(); 
        }

        function stopDrawing(event) {
            drawing = false;
            currentPath = null;
            event.preventDefault(); 
        }

        function getPosition(event, svg) {
            const rect = svg.getBoundingClientRect();
            if (event.touches) {
                return {
                    x: event.touches[0].clientX - rect.left,
                    y: event.touches[0].clientY - rect.top
                };
            } else {
                return {
                    x: event.clientX - rect.left,
                    y: event.clientY - rect.top
                };
            }
        }

        function createPath(startPoint) {
            const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
            path.setAttribute("d", `M ${startPoint.x} ${startPoint.y}`);
            path.setAttribute("stroke", "black");
            path.setAttribute("stroke-width", "2");
            path.setAttribute("fill", "none");
            return path;
        }

        function addPointToPath(path, point) {
            const d = path.getAttribute("d");
            path.setAttribute("d", `${d} L ${point.x} ${point.y}`);
        }

        svg.addEventListener("mousedown", startDrawing);
        svg.addEventListener("mousemove", draw);
        svg.addEventListener("mouseup", stopDrawing);
        svg.addEventListener("mouseleave", stopDrawing);

        svg.addEventListener("touchstart", startDrawing);
        svg.addEventListener("touchmove", draw);
        svg.addEventListener("touchend", stopDrawing);
        svg.addEventListener("touchcancel", stopDrawing);

        if (clearButton) {
            clearButton.addEventListener("click", () => {
                while (svg.firstChild) {
                    svg.removeChild(svg.firstChild);
                }
            });
        } else {
            console.error("Le bouton n'est pas trouvable");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const addRowButton = document.getElementById('addRow');
    const inputTableBody = document.querySelector('#inputTable tbody');

    addRowButton.addEventListener('click', function () {
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="number" class="form-control" name="quantite[]" required></td>
            <td><input type="text" class="form-control" name="designation[]" required></td>
        `;

        inputTableBody.appendChild(newRow);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const addSectionButton = document.getElementById('addSection');
    const formSections = document.getElementById('form-sections');

    addSectionButton.addEventListener('click', function () {
        const newSection = document.createElement('div');
        newSection.innerHTML = `
            <div class="row">
              <div class="col">
                <label for="Temps d'Aller" class="form-label">Temps de Route Aller</label>
                <p id="Aller"></p>
                <input type="range" class="form-range" id="aller" min="0" max="24" step="0.25" required>
              </div>
              <div class="col">
                <label for="tempsTravail">Temps de Travail</label>
                <p id="Travail"></p>
                <input type="range" class="form-range" id="travail" min="0" max="24" step="0.25" required>
              </div>
              <div class="col">
                <label for="tempsRouteRetour">Temps de Retour</label>
                <p id="Retour"></p>
                <input type="range" class="form-range" id="retour" min="0" max="24" step="0.25" required>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="Km">Nombre de Km</label>
                <input type="number" class="form-control">
              </div>
              <div class="col">
                <label for="forfait">Nombre de forfait</label>
                <input type="number" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="hebergements">Nombre d'hébergements</label>
                <input type="number" class="form-control">
              </div>
              <div class="col">
                <label for="repas">Nombre de repas</label>
                <input type="number" class="form-control">
              </div>
              <div class="col">
                <label for="divers">Divers</label>
                <input type="text" class="form-control">
              </div>
            </div>
        `;
        formSections.appendChild(newSection);
    });
});

document.getElementById('pdfButton').addEventListener('click', function () {
    const buttons = document.querySelectorAll('#formContent button');
    const formContent = document.getElementById('formContent');

    if (isFormContentEmpty(formContent)) return;

    hideButtons(buttons);
    changeBackgroundColor(formContent, 'white');

    generatePDF(formContent)
        .then(pdfBlob => {
            savePDF(pdfBlob, 'doc.pdf');
            return uploadPDF(pdfBlob);
        })
        .then(() => {
            window.location.href = '../Mon compte.html';
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            showButtons(buttons);
            restoreBackgroundColor(formContent);
        });
});
function isFormContentEmpty(formContent) {
    if (formContent.innerHTML.trim() === '') {
        console.error('Form content est vide');
        return true;
    }
    return false;
}

function hideButtons(buttons) {
    buttons.forEach(button => button.style.display = 'none');
}

function showButtons(buttons) {
    buttons.forEach(button => button.style.display = '');
}

function changeBackgroundColor(element, color) {
    element.dataset.originalBackgroundColor = element.style.backgroundColor;
    element.style.backgroundColor = color;
}

function restoreBackgroundColor(element) {
    element.style.backgroundColor = element.dataset.originalBackgroundColor;
}

function generatePDF(formContent) {
    const scale = 2;
    const canvasOptions = { scale: scale };

    return html2canvas(formContent, canvasOptions).then(canvas => {
        const imgData = canvas.toDataURL('image/png', 1);
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        let heightLeft = pdfHeight;
        let position = 0;

        pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
        heightLeft -= pdf.internal.pageSize.getHeight();

        while (heightLeft >= 0) {
            position = heightLeft - pdfHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
            heightLeft -= pdf.internal.pageSize.getHeight();
        }

        return pdf.output('blob');
    });
}

function savePDF(pdfBlob, filename) {
    const link = document.createElement('a');
    link.href = URL.createObjectURL(pdfBlob);
    link.download = filename;
    link.click();
    URL.revokeObjectURL(link.href);
}

function uploadPDF(pdfBlob) {
    const formData = new FormData();
    formData.append('pdfFile', pdfBlob, 'doc.pdf');

    return fetch('http://localhost:80', { 
        method: 'POST',
        body: formData
    }).then(response => {
        if (!response.ok) {
            throw new Error('Failed to process PDF');
        }
    });
}

const checkboxes = document.querySelectorAll('.form-check-input'); 
checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', () => {
        const isChecked = Array.from(checkboxes).some((cb) => cb.checked); 

        const submitButton = document.querySelector('input[type="submit"]');
        if (submitButton) {
            submitButton.disabled = !isChecked;
        }
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

$(function() {
    $('#danger').click(function() {
        if ($(this).is(':checked')) {
            $('#danger-description').closest('.col').attr('hidden', false);
        } else {
            $('#danger-description').closest('.col').attr('hidden', true);
        }
    });
});

const openCameraBtn = document.getElementById('open-camera-btn');
const cameraInput = document.getElementById('camera-input');
const capturedImg = document.getElementById('captured-img');
const capturedImgData = document.getElementById('captured-img-data');

openCameraBtn.addEventListener('click', function() {
    cameraInput.click();
});

function setupSlider(id, timeDisplayId) {
    var slider = document.getElementById(id);
    var selectedTime = document.getElementById(timeDisplayId);
  
    slider.addEventListener("input", function() {
      var selectedHour = Math.floor(this.value);
      var selectedMinute = Math.round((this.value - selectedHour) * 60);
      selectedTime.textContent = selectedHour + "h " + selectedMinute + "m";
    });
}
setupSlider("aller", "Aller");
setupSlider("travail", "Travail");
setupSlider("retour", "Retour");

const micIcon = document.querySelector('.mic');

micIcon.addEventListener('pointerdown', requestMicrophonePermission);

function requestMicrophonePermission(event) {
      event.preventDefault();
      console.log('Requesting microphone permission...');
      
      if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ audio: true })
          .then(function(stream) {
            console.log('Microphone permission granted.');
            startSpeechRecognition();
          })
          .catch(function(err) {
            console.error('Permission refusée ou une erreur est survenue: ', err);
            alert('Permission de microphone refusée ou une erreur est survenue.');
          });
      } else {
        console.error('getUserMedia not supported in this browser.');
        alert('Votre navigateur ne supporte pas getUserMedia. Veuillez utiliser un navigateur compatible comme Chrome, Firefox, Edge, ou Safari.');
      }
}

function startSpeechRecognition() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!SpeechRecognition) {
          alert("Votre navigateur ne supporte pas l'API Web Speech Recognition. Veuillez utiliser un navigateur compatible comme Chrome, Firefox, Edge, ou Safari.");
          return;
        }
  
        const recognition = new SpeechRecognition();
        recognition.lang = 'fr-FR';
        recognition.onstart = function() {
          console.log('Speech recognition started.');
        };
        recognition.onresult = function(event) {
          const speechResult = event.results[0][0].transcript;
          console.log('Speech recognition result: ', speechResult);
          document.getElementById('text-to-read').value += speechResult;
        };
        recognition.onerror = function(event) {
          console.error('Erreur de reconnaissance vocale: ', event.error);
          alert('Erreur de reconnaissance vocale: ' + event.error);
        };
        recognition.onend = function() {
          console.log('Speech recognition ended.');
        };
        recognition.start();
}

document.addEventListener("DOMContentLoaded", function () {
    const addRowButton = document.getElementById('int');
    const inputTableBody = document.getElementById('in');

    addRowButton.addEventListener('click', function () {
        const int = document.createElement('div');

        int.innerHTML = `
        <input type="text" class="form-control" required>
        <br>
        `;

        inputTableBody.appendChild(int);
    });
});
