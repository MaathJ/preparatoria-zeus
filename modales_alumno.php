    <div class="modal fade  " id="ModalEliminarD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                    <h5 class="modal-title" id="exampleModalLabel">CONFIRMAR ELIMINACION DE ALUMNO:</h5>
                </div>
                <div class="modal-body">
                    <form action="./Alumno/D_alumno.php" method="post">
                        <h5>¿Está seguro que desea eliminar al alumno?</h5>
                        <input type="text" name="codalD" id="id_alumnoD" class="form-control" hidden>
                        <div class="modal-footer">
                            <input type="hidden" name="id_rol_seleccionado" id="id_rol_seleccionado" value="">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button type="submit" class="btn btn-danger" id="">ELIMINAR</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="ModalRegistrar">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">REGISTRO INDIVIDUAL</h4>
                </div>
                <div class="modal-body container-fluid">
                    <form action="./Alumno/R_alumno.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 ml-1">
                                <h3>DATOS DEL ALUMNO</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ml-1">
                                <hr class="border-top">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-12">
                                    <label for="Apellido-name" class="form-label">Apellidos:</label>
                                    <input type="text" name="txtapellido" class="form-control" id="Apellido-name" required>
                                </div>
                                <div class="col-12">
                                    <label for="Nombre-name" class="form-label">Nombres:</label>
                                    <input type="text" name="txtnombre" class="sm-5 form-control" id="Nombre-name" required>
                                </div>
                                <div class="col-12">
                                    <label for="Dni-name" class="form-label">Dni:</label>
                                    <input type="number" name="txtdni" class="form-control" id="Dni-name" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" required>
                                </div>
                                <div class="col-12">
                                    <label for="Telefono-name" class="form-label" style="color: black;">Celular:</label>
                                    <input type="number" name="txttelefono" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="9" id="Telefono-name" required>
                                </div>
                                <div class="col-12">
                                    <label for="genero-name" class="form-label" style="color: black;">Genero:</label>
                                    <select name="lstgenero" id="Genero-name" class="form-control" aria-label="Default select example">
                                        <option value="MASCULINO" selected>MASCULINO</option>
                                        <option value="FEMENINO">FEMENINO</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="fechanac-name" class="form-label text-nowrap" style="color: black;">Fecha de Nac:</label>
                                    <input type="date" name="txtfnac" class="form-control" id="Fenac-alumno" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-12">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; ">
                                        <img src="./src/assets/images/img_fond.jpg" alt="avatar" id="img" width="150" height="150" style="object-fit: cover;">
                                        <input type="file" name="foto" id="foto" accept="image/*">
                                        <label class="btn_img btn-primary" for="foto">CAMBIAR FOTO</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="colegio-name" class="form-label" style="color: black;">Colegio:</label>
                                    <input type="text" name="txtcolegio" class="form-control" id="Colegio-alumno" required>
                                </div>
                                <div class="col-12">
                                    <label for="Direccion-name" class="form-label">Ciudad:</label>
                                    <input type="text" name="txtciudad" class="form-control" id="Ciudad-name" required>
                                </div>
                                <div class="col-12">
                                    <label for="Direccion-name" class="form-label">Direccion:</label>
                                    <input type="text" name="txtdireccion" class="form-control" id="Direccion-name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ml-1">
                                <h3>DATOS DE LA UNIVERSIDAD</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ml-1">
                                <hr class="border-top">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-12">
                                    <label class="form-label" for="area">Area:</label>
                                    <select class="form-control" name="lstarea" id="area-alumno">
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="carrera">Carrera:</label>
                                    <select class="form-control" name="lstcarrera" id="carrera-alumno">
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="col-12">
                                    <label class="form-label" for="universidad">Universidad:</label>
                                    <select class="form-control" name="lstcarrera" id="universidad-alumno">
                                        <option value="UNAP" selected>UNAP</option>
                                        <option value="UNSA">UNSA</option>
                                        <option value="UNAJ">UNAJ</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ml-1">
                                <h3>DATOS DEL APODERADO</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ml-1">
                                <hr class="border-top">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-12">
                                    <label class="form-label" for="nombrea-alumno">Apellidos y Nombres:</label>
                                    <input name="nombrea-alumno" class="form-control" type="text" id="Nombrea-alumno">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-12">
                                    <label class="form-label" for="celulara-alumno">Celular:</label>
                                    <input name="celulara-alumno" class="form-control" type="text" id="Celulara-alumno">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button type="submit" class="btn btn-primary">REGISTRARSE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-xl modal-fluid" id="ModalEditar">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModal2Label">EDITAR REGISTRO</h4>
                </div>
                <div class="modal-body">
                    <form action="./Alumno/U_alumno.php" method="post" enctype="multipart/form-data">
                        <div class="row text-nowrap">
                            <div class="col-md-8 ml-1">
                                <h3>DATOS DEL ALUMNO</h3>
                            </div>
                            <div class="col-md-3 ml-1 text-nowrap">
                                <input name="checkestado" class="form-check-input" type="checkbox" value="ACTIVO" checked>
                                <label class="form-check-label text-black" for="miCheckbox">ACTIVO</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12  ml-1">
                                <hr class=" border-top">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-12">
                                    <label for="Apellido-name" class="form-label sm-5" style="color: black;">Apellidos:</label>
                                    <input type="text" name="txtapellidoU" class="form-control" id="Apellido-nameU" required>
                                    <input type="text" name="id_alumnoU" class="form-control" id="id_alumnoU" hidden>
                                </div>
                                <div class="col-12">
                                    <label for="Nombre-name" class="form-label" style="color: black;">Nombres:</label>
                                    <input type="text" name="txtnombreU" class="sm-5 form-control" id="Nombre-nameU" required>
                                </div>
                                <div class="col-12">
                                    <label for="Dni-name" class="form-label" style="color: black;">Dni:</label>
                                    <input type="number" name="txtdniU" class="form-control" id="Dni-nameU" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" required>
                                </div>
                                <div class="col-12">
                                    <label for="Telefono-name" class="form-label" style="color: black;">Celular:</label>
                                    <input type="number" name="txttelefonoU" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="9" id="Telefono-nameU" required>
                                </div>
                                <div class="col-12">
                                    <label for="genero-name" class="form-label" style="color: black;">Genero:</label>
                                    <select name="lstgeneroU" id="Genero-nameU" class="form-control" aria-label="Default select example">
                                        <option value="MASCULINO" selected>MASCULINO</option>
                                        <option value="FEMENINO">FEMENINO</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="fechanac-name" class="form-label text-nowrap" style="color: black;">Fecha de Nac:</label>
                                    <input type="date" name="txtfnacU" class="form-control" id="Fenac-alumnoU" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="col-12">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; ">
                                        <img src="./src/assets/images/img_fond.jpg" alt="avatar" id="img2" width="200" height="200">
                                        <input type="file" name="foto2" id="foto2" accept="image/*">
                                        <label class="btn_img btn-danger" for="foto2">CAMBIAR FOTO</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="colegio-name" class="form-label">Colegio:</label>
                                    <input type="text" name="txtcolegioU" class="form-control" id="Colegio-alumnoU" required>
                                </div>
                                <div class="col-12">
                                    <label for="Direccion-name" class="form-label">Ciudad:</label>
                                    <input type="text" name="txtciudadU" class="form-control" id="Ciudad-nameU" required>
                                </div>
                                <div class="col-12">
                                    <label for="Direccion-name" class="form-label">Direccion:</label>
                                    <input type="text" name="txtdireccionU" class="form-control" id="Direccion-nameU">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ml-1">
                                <h3>DATOS DE LA UNIVERSIDAD</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ml-1">
                                <hr class=" border-top">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-12">
                                    <label class="form-label" for="area">Area:</label>
                                    <select class="form-control" name="lstareaU" id="Area-alumnoU">
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="ml-2" for="carrera">Carrera:</label>
                                    <select class="form-control" name="lstcarreraU" id="Carrera-alumnoU">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-12">
                                    <label class="form-label" for="universidad">Universidad:</label>
                                    <select class="form-control" name="lstuniversidadU" id="Universidad-alumnoU">
                                        <option value="UNAP" selected>UNAP</option>
                                        <option value="UNSA">UNSA</option>
                                        <option value="UNAJ">UNAJ</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ml-1">
                                <h3>DATOS DEL APODERADO</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ml-1">
                                <hr class=" border-top">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-12">
                                    <label class="form-label" for="nombrea-alumno">Apellidos y Nombres:</label>
                                    <input name="nombrea-alumnoU" class="form-control" type="text" id="Nombrea-alumnoU">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-12">
                                    <label class="form-label" for="celulara-alumno">Celular:</label>
                                    <input name="celulara-alumnoU" class="form-control" type="text" id="Celulara-alumnoU">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button type="submit" class="btn btn-primary">EDITAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>