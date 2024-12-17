<template>
    <div>
        <div>
            <footer class="footer fondolateral">
                <div class="container">
                    <div class="row gx-3"> <!-- Usamos gx-3 para reducir la separación horizontal -->
                        <!-- Primera mitad: Desarrollado Por -->
                        <div class="col-12 col-md-6 mb-2 mb-md-0 text-center text-md-start">
                            <h5>Sobre nosotros: </h5>
                            <p><strong>BunnySoft</strong> es una empresa dedicada al desarrollo de tecnología,
                                ofreciendo soluciones innovadoras para mejorar la experiencia y eficiencia en diversos
                                campos.</p>
                            <p>Este proyecto ha sido desarrollado por:</p>
                            <p><strong>Ing. Luis Medina</strong> <a
                                    href="mailto:luis_medina124@hotmail.com">luis_medina124@hotmail.com</a><br>
                                Desarrollador de software y arquitecto de sistemas.</p>
                            <p><strong>Lic. Katherine Urbina</strong> <a
                                    href="mailto:kmurbina1510@gmail.com">kmurbina1510@gmail.com</a><br>
                                Especialista en diseño de interfaces y experiencia del usuario.</p>

                            <img src="@/assets/BonnySoft.png" alt="Logo o imagen representativa" class="img-fluid ms-3"
                                style="max-width: 100px;">
                        </div>


                        <!-- Segunda mitad: Redes Sociales -->
                        <div class="col-12 col-md-6 mb-2 mb-md-0 text-center text-md-justify">
                            <h5>Redes sociales de inversiones caru:</h5>
                            <p>
                                <a href="https://wa.me/04129939101" target="_blank">
                                    <i class="fab fa-whatsapp"></i> 04129939101
                                </a>
                            </p>
                            <p>
                                <a href="https://www.instagram.com/inversionescaru_ayd" target="_blank">
                                    <i class="fab fa-instagram"></i> inversionescaru_ayd
                                </a>
                            </p>
                        </div>

                    </div>
                </div>

            </footer>
        </div>

    </div>
</template>
<style>
.fondolateral {
    background: linear-gradient(to bottom, #045872, #034a58, #02343f);
    /* Azul oscuro para el fondo lateral */
}

.footer {
    color: #ffffff;
    /* Texto blanco */
    padding: 20px 0;
    /* Espaciado vertical */
    text-align: center;
    /* Centra el texto */
    position: relative;

    /* Cambia a "absolute" si necesitas que esté detrás del contenido */
    /* Asegura que el footer esté detrás del contenido */
}

.footer h5 {
    font-weight: bold;
}

.footer p {
    margin-bottom: 0;
}
</style>