const linkEstudiante = document.getElementById('links-estudiante')
console.log(linkEstudiante)
const onClickEstudiante = document.getElementById('button-estudiante')
console.log(onClickEstudiante)
onClickEstudiante.addEventListener('click', () =>{
    linkEstudiante.classList.toggle('onclick')
})

//MENU-LINKS CICLO
const linkCiclo = document.getElementById('links-ciclo')
console.log(linkCiclo)
const onClickCiclo = document.getElementById('button-ciclo')
console.log(onClickCiclo)
onClickCiclo.addEventListener('click', () =>{
    linkCiclo.classList.toggle('onclick')
})

//MENU-LINKS USUARIO
const linkUsuario = document.getElementById('links-usuario')
console.log(linkUsuario)
const onClickUsuario = document.getElementById('button-usuario')
console.log(onClickUsuario)
onClickUsuario.addEventListener('click', () =>{
    linkUsuario.classList.toggle('onclick')
})