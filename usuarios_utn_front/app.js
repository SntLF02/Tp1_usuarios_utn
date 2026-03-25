// URL base del backend
const BASE_URL = "http://localhost/TP1_usuarios_utn/usuarios_utn_bkend";

// --- LOGIN ---
document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", function(e) {
      e.preventDefault();
      const user = document.getElementById("user").value;
      const pass = document.getElementById("pass").value;
      login(user, pass);
    });
  }

  const btnBuscar = document.getElementById("btnBuscar");
  if (btnBuscar) {
    btnBuscar.addEventListener("click", buscarUsuario);
    cargarUsuarios(); // carga inicial de la tabla
  }
});

function login(user, pass) {
  fetch(`${BASE_URL}/login.php?user=${user}&pass=${pass}`)
    .then(res => res.json())
    .then(data => {
      if (data.respuesta === "OK") {
        // Mostrar el cartel
        alert(data.mje);
        // Redirigir automáticamente después de cerrar el alert
        window.location.href = "/TP1_usuarios_utn/usuarios_utn_front/lista.html";

      } else {
        alert(data.mje);
      }
    })
    .catch(error => {
      console.error("Error en login:", error);
      alert("Hubo un problema al conectar con el servidor.");
    });
}


function cargarUsuarios() {
  fetch(`${BASE_URL}/lista.php?action=BUSCAR`)
    .then(res => res.json())
    .then(data => renderTabla(data));
}

function buscarUsuario() {
  const usuario = document.getElementById("buscar").value;
  fetch(`${BASE_URL}/lista.php?action=BUSCAR&usuario=${usuario}`)
    .then(res => res.json())
    .then(data => renderTabla(data));
}

function actualizarEstado(idUser, estado) {
  fetch(`${BASE_URL}/lista.php?action=ACTUALIZAR_ESTADO&idUser=${idUser}&estado=${estado}`)
    .then(res => res.json())
    .then(data => {
      alert(data.mje);
      cargarUsuarios(); // refresca la tabla
    });
}

function renderTabla(data) {
  const tbody = document.querySelector("#tablaUsuarios tbody");
  tbody.innerHTML = "";
  data.forEach(u => {
    const fila = document.createElement("tr");
    fila.id = `fila-${u.id}`;
    fila.className = (u.bloqueado === "Y") ? "bloqueado" : "desbloqueado";
    fila.innerHTML = `
      <td>${u.id}</td>
      <td>${u.usuario}</td>
      <td>${u.apellido}</td>
      <td>${u.nombre}</td>
      <td>${u.bloqueado}</td>
      <td>
        <button onclick="actualizarEstado(${u.id}, 'Y')">Bloquear</button>
        <button onclick="actualizarEstado(${u.id}, 'N')">Desbloquear</button>
      </td>
    `;
    tbody.appendChild(fila);
  });
}
