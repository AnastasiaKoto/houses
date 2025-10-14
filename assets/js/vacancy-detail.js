document.addEventListener("DOMContentLoaded", () => {
  const dropArea = document.getElementById("fileUpload");
  const fileInput = document.getElementById("fileInput");
  const fileLabel = document.getElementById("fileLabel");


  ["dragenter", "dragover"].forEach(eventName => {
    dropArea.addEventListener(eventName, e => {
      e.preventDefault();
      dropArea.classList.add("dragover");
    });
  });

  ["dragleave", "drop"].forEach(eventName => {
    dropArea.addEventListener(eventName, e => {
      e.preventDefault();
      dropArea.classList.remove("dragover");
    });
  });

 
  dropArea.addEventListener("drop", e => {
    const file = e.dataTransfer.files[0];
    handleFile(file);
  });

  
  fileInput.addEventListener("change", e => {
    const file = e.target.files[0];
    handleFile(file);
  });

  function handleFile(file) {
    if (!file) return;

    const allowedTypes = [
      "application/pdf",
      "application/msword",
      "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
    ];

    if (!allowedTypes.includes(file.type)) {
      alert("Разрешены только файлы DOC, DOCX или PDF");
      fileInput.value = "";
      resetLabel();
      return;
    }

    const sizeKB = (file.size / 1024).toFixed(1);

    fileLabel.innerHTML = `
      <div class="file-info">
        <div class="size">Размер: ${sizeKB} КБ</div>
        <div class="name">${file.name}</div>
      </div>
    `;
  }

  function resetLabel() {
    fileLabel.innerHTML = `
      <div class="file-label-top">Формат файла – DOC, PDF</div>
      <div class="file-label-main">Выберите или перетащите файл в эту область</div>
    `;
  }
});