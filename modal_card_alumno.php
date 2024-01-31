<?php
include_once('auth.php');
?>
<div class="modal fade " id="ModalCardInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-user-modal">
                    <div class="card-logo">
                        <img class="card-logo-img" id="card-logo-img" src="#card-logo-img">
                    </div>
                    <div class="card-important-info">
                        <div class="user-name" id="card-user" style="color: #010133; font-weight: bold; font-size: 1.3rem;">
                        </div>
                        <div class="user-edad" id="card-edad" style="text-align: center;">
                        </div>
                        <div class="card-cont-important-info">
                            <div id="card-estado"></div>
                            <div id="card-dni"></div>
                            <div id="card-fnac" class="text-nowrap"></div>
                        </div>
                    </div>
                    <div class="card-more-info">
                        <div class="info-user-more telefono">
                            <i class="fa-solid fa-phone"></i>
                            <span id="card-cel"></span>
                        </div>
                        <div class="info-user-more direccion">
                            <i class="fa-solid fa-house"></i>
                            <span id="card-dir"></span>
                        </div>
                        <div class="info-user-more colegio">
                            <i class="fa-solid fa-school"></i>
                            <span id="card-col"></span>
                        </div>
                        <div class="info-user-more universidad">
                            <i class="fa-solid fa-building-columns"></i>
                            <span id="card-uni"></span>
                        </div>
                    </div>
                    <div class="card-apoderado-info">
                        <div style="color: #010133; font-weight: bold;"></div>
                        <div>
                            <div class="info-user-more apoderado">
                                <i class="fa-solid fa-user" id="apo-icon-1"></i>
                                <span id="card-napo"></span>
                            </div>
                            <div class="info-user-more telefono-apoderado">
                                <i class="fa-solid fa-phone" id="apo-icon-2"></i>
                                <span id="card-ntel"></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>