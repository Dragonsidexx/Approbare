function editProfile() {
    document.getElementById('profileDetails').style.display = 'none';
    document.getElementById('editProfile').style.display = 'block';
    document.getElementById('editBtn').style.display = 'none';
}

function cancelEdit() {
    document.getElementById('profileDetails').style.display = 'block';
    document.getElementById('editProfile').style.display = 'none';
    document.getElementById('editBtn').style.display = 'inline-block';
}

document.getElementById('editForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var errorMessage = document.getElementById('errorMessage');
    errorMessage.textContent = "";

    var nome = document.getElementById('editNome').value;
    var email = document.getElementById('editEmail').value;
    var telefone = document.getElementById('editTelefone').value;

    if (!nome || !email || !telefone) {
        errorMessage.textContent = "Todos os campos são obrigatórios!";
        return;
    }

    alert("Alterações salvas com sucesso!");
    cancelEdit();
});

