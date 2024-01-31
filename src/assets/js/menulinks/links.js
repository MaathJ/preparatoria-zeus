const linkEstudiante = document.getElementById('links-estudiante')
const onClickEstudiante = document.getElementById('button-estudiante')
onClickEstudiante.addEventListener('click', () =>{
    linkEstudiante.classList.toggle('onclick')
})

//MENU-LINKS CICLO
const linkCiclo = document.getElementById('links-ciclo')
const onClickCiclo = document.getElementById('button-ciclo')
onClickCiclo.addEventListener('click', () =>{
    linkCiclo.classList.toggle('onclick')
})

//MENU-LINKS USUARIO
const linkUsuario = document.getElementById('links-usuario')

const onClickUsuario = document.getElementById('button-usuario')

onClickUsuario.addEventListener('click', () =>{
    linkUsuario.classList.toggle('onclick')
})