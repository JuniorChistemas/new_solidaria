<template>
    <div class="app-container" :class="{ dark: isDarkMode }">
        <div
            class="bg-white dark:bg-gray-950 text-gray-800 dark:text-gray-100 min-h-screen transition-colors duration-500"
        >
            <!-- Header/Hero Section -->
            <section class="relative py-20 lg:py-32 overflow-hidden">
                <div class="container mx-auto px-6 max-w-5xl relative z-10">
                    <div
                        class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16"
                    >
                        <div class="w-full lg:w-1/2 space-y-8">
                            <div
                                class="inline-flex items-center px-4 py-1.5 rounded-full bg-blue-100/50 dark:bg-green-900/20 text-blue-600 dark:text-blue-400 text-sm font-medium"
                            >
                                <span class="mr-2">✦</span> Farmacia Solidaria
                            </div>
                            <h1
                                class="text-5xl lg:text-6xl font-light leading-tight tracking-tight"
                            >
                                <span
                                    class="text-blue-600 dark:text-blue-600 font-normal"
                                    >Tu Salud,
                                </span>
                                <span class="text-gray-900 dark:text-white"
                                    >Nuestra Prioridad</span
                                >
                            </h1>
                            <p
                                class="text-lg text-gray-600 dark:text-gray-300 font-light leading-relaxed max-w-md"
                            >
                                Contribuimos al bienestar de todos, ofreciendo
                                atención farmacéutica personalizada, productos
                                accesibles y un firme compromiso con tu salud.
                            </p>
                            <div
                                class="flex flex-wrap gap-5 pt-2 z-20 relative"
                            >
                                <!-- Botón -->
                                <a href="/login" class="block w-full sm:w-auto">
                                    <button
                                        class="w-full px-8 py-4 sm:py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-light rounded-lg transition duration-300 shadow-lg hover:shadow-xl shadow-blue-600/10 dark:shadow-blue-500/5 active:bg-blue-800 active:scale-95"
                                    >
                                        INGRESAR
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2 relative z-0">
                            <!-- Fondos decorativos sin interactividad -->
                            <div
                                class="absolute -top-20 -right-20 w-64 h-64 bg-blue-400/10 dark:bg-blue-500/5 rounded-full filter blur-2xl pointer-events-none"
                            ></div>
                            <div
                                class="absolute -bottom-10 -left-10 w-48 h-48 bg-blue-400/10 dark:bg-blue-500/5 rounded-full filter blur-3xl pointer-events-none"
                            ></div>
                            <img
                                src="/images/landing/system/representlanding.png"
                                alt="Farmacia Solidaria"
                                class="rounded-2xl shadow-2xl w-full relative z-10 border border-gray-100 dark:border-gray-900"
                            />
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sobre Nosotros Section -->
            <section class="relative py-20 lg:py-32 overflow-hidden">
                <div class="container mx-auto px-6 max-w-5xl relative z-10">
                    <div
                        class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16"
                    >
                        <!-- Imagen a la derecha -->
                        <div class="w-full lg:w-1/2 relative z-0">
                            <div
                                class="absolute -top-20 -right-20 w-64 h-64 bg-blue-400/10 dark:bg-blue-500/5 rounded-full filter blur-2xl pointer-events-none"
                            ></div>
                            <div
                                class="absolute -bottom-10 -left-10 w-48 h-48 bg-blue-400/10 dark:bg-blue-500/5 rounded-full filter blur-3xl pointer-events-none"
                            ></div>
                            <img
                                src="/images/landing/system/empresa2.png"
                                alt="Sobre Nosotros"
                                class="rounded-2xl shadow-2xl w-full relative z-10 border border-gray-100 dark:border-gray-900"
                            />
                        </div>

                        <!-- Texto a la izquierda -->
                        <div class="w-full lg:w-1/2 space-y-8">
                            <!-- Título principal -->
                            <h1
                                class="text-5xl lg:text-6xl font-light leading-tight tracking-tight"
                            >
                                <span class="text-gray-900 dark:text-white"
                                    >Sobre Nosotros</span
                                >
                            </h1>

                            <!-- Subtítulo -->
                            <h5
                                class="text-uppercase text-default mb-3"
                                style="color: #3ebd5a"
                            >
                                Una Cadena de Farmacias que se Caracteriza por
                                la Gran Atención y la Comodidad de Nuestros
                                Precios
                            </h5>

                            <!-- Misión y Visión (reducidos y resumidos) -->
                            <p
                                class="text-lg text-gray-600 dark:text-gray-300 font-light leading-relaxed mb-4"
                            >
                                <b>Misión:</b> Contribuir al bienestar de los
                                ciudadanos, ofreciendo el mejor servicio
                                farmacéutico con productos de alta calidad y un
                                personal amable.
                            </p>

                            <p
                                class="text-lg text-gray-600 dark:text-gray-300 font-light leading-relaxed mb-4"
                            >
                                <b>Visión:</b> Ser una empresa líder, reconocida
                                en el mundo farmacéutico, por nuestra dedicación
                                a la satisfacción del cliente y el compromiso
                                con la calidad.
                            </p>

                            <!-- Botón de Leer Más -->
                            <a href="login" class="block w-full sm:w-auto">
                                <button
                                    class="w-full px-8 py-4 sm:py-3.5 bg-[#17a2b8] hover:bg-[#138496] text-white font-light rounded-lg transition duration-300 shadow-lg hover:shadow-xl shadow-blue-600/10 dark:shadow-blue-500/5 active:bg-[#117a8b] active:scale-95"
                                >
                                    LEER MÁS
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- System Information Section -->
            <section class="py-24 bg-gray-50 dark:bg-gray-900/20 px-6">
                <div class="container mx-auto max-w-5xl">
                    <div class="text-center mb-16 fade-in">
                        <span
                            class="inline-block px-4 py-1.5 bg-blue-100/50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-600 text-sm font-medium rounded-full mb-4"
                            >Farmacia Solidaria</span
                        >
                        <h2 class="text-3xl font-light mb-6 tracking-tight">
                            Nuestros Servicios
                        </h2>
                        <p
                            class="max-w-2xl mx-auto text-gray-600 dark:text-gray-300 font-light"
                        >
                            Contribuimos al bienestar de los ciudadanos,
                            ofreciendo servicios farmacéuticos de alta calidad
                            con atención personalizada y precios accesibles.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8"
                    >
                        <!-- Consulta Personalizada -->
                        <div
                            class="bg-white dark:bg-gray-900/40 backdrop-blur-sm rounded-2xl shadow-xl dark:shadow-gray-950/50 p-8 system-card fade-in hover:translate-y-[-5px] transition-all duration-300"
                        >
                            <div class="text-blue-600 dark:text-blue-400 mb-6">
                                <i class="fas fa-user-md text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-light mb-4">
                                Consulta Personalizada
                            </h3>
                            <p
                                class="text-gray-600 dark:text-gray-300 font-light"
                            >
                                En cada sucursal contamos con un químico
                                farmacéutico para una mejor atención.
                            </p>
                        </div>

                        <!-- Precios Bajos -->
                        <div
                            class="bg-white dark:bg-gray-900/40 backdrop-blur-sm rounded-2xl shadow-xl dark:shadow-gray-950/50 p-8 system-card fade-in hover:translate-y-[-5px] transition-all duration-300"
                        >
                            <div class="text-blue-600 dark:text-blue-400 mb-6">
                                <i class="fas fa-tags text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-light mb-4">
                                Precios Bajos
                            </h3>
                            <p
                                class="text-gray-600 dark:text-gray-300 font-light"
                            >
                                Los mejores precios del mercado a tu
                                disposición, todos los días.
                            </p>
                        </div>

                        <!-- Medicamentos Variados -->
                        <div
                            class="bg-white dark:bg-gray-900/40 backdrop-blur-sm rounded-2xl shadow-xl dark:shadow-gray-950/50 p-8 system-card fade-in hover:translate-y-[-5px] transition-all duration-300"
                        >
                            <div class="text-blue-600 dark:text-blue-400 mb-6">
                                <i class="fas fa-pills text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-light mb-4">
                                Medicamentos Variados
                            </h3>
                            <p
                                class="text-gray-600 dark:text-gray-300 font-light"
                            >
                                Diversidad en medicamentos, tanto comerciales
                                como genéricos disponibles.
                            </p>
                        </div>

                        <!-- Formas de Pago -->
                        <div
                            class="bg-white dark:bg-gray-900/40 backdrop-blur-sm rounded-2xl shadow-xl dark:shadow-gray-950/50 p-8 system-card fade-in hover:translate-y-[-5px] transition-all duration-300"
                        >
                            <div class="text-blue-600 dark:text-blue-400 mb-6">
                                <i class="fas fa-credit-card text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-light mb-4">
                                Formas de Pago
                            </h3>
                            <p
                                class="text-gray-600 dark:text-gray-300 font-light"
                            >
                                Aceptamos todo tipo de tarjetas en cada sucursal
                                para tu comodidad.
                            </p>
                        </div>
                    </div>
                </div>
            </section>








<section class="py-24 px-6 bg-gray-50 dark:bg-gray-900/20">
    <div class="container mx-auto max-w-5xl">
        <!-- Título principal -->
        <div class="text-center mb-16 fade-in">
            <h2 class="text-3xl font-light mb-6 tracking-tight">
                <span class="text-blue-600 dark:text-blue-600">Nuestras</span> Marcas Propias
            </h2>
            <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-300 font-light">
                Conoce nuestras marcas exclusivas para el cuidado de tu salud, disponibles en todas nuestras sucursales.
            </p>
        </div>

        <!-- Filtros de categorías -->
        <div class="text-center mb-8">
            <ul class=" mb-4" id="portfolio-flters">
                <li class="btn btn-outline-dark list-inline text-uppercase py-2 px-4" :class="{ 'active': activeFilter === '*' }" @click="changeFilter('*')">
                    <i class="pi pi-star text-primary mr-2"></i> TODO
                </li>
                <li class="btn btn-outline-dark list-inline text-uppercase py-2 px-4" :class="{ 'active': activeFilter === 'first' }" @click="changeFilter('first')">
                    <i class="pi pi-baby-carriage list-inline text-success mr-2"></i> Embarazo
                </li>
                <li class="btn btn-outline-dark list-inline text-uppercase py-2 px-4" :class="{ 'active': activeFilter === 'second' }" @click="changeFilter('second')">
                    <i class="pi pi-heart text-success mr-2"></i> Pulmones
                </li>
            </ul>
            <div class="flex justify-center">
                <!-- Botón para descargar catálogo centrado -->
                <a download="Catalogo" href="source/catalogo.pdf" class="navbar-brand text-secondary">
                    <img title="Descargar Catalogo" alt="Descargar Catálogo" src="images/landing/system/catalogo.png" class="img-fluid mt-5 mt-lg-0" width="120" height="100">
                </a>
            </div>
        </div>

        <!-- Galería de marcas -->
        <div class="row portfolio-container">
            <div v-for="(brand, index) in filteredItems" :key="index" class="col-lg-4 col-md-6 mb-4 portfolio-item" :class="brand.category">
                <div class="position-relative rounded overflow-hidden mb-2">
                    <img class="img-fluid w-100 h-72 object-cover" :src="brand.imgSrc" :alt="brand.name">
                    <div class="portfolio-btn d-flex align-items-center justify-content-center">
                        <a :href="brand.imgSrc" data-lightbox="portfolio">
                            <i class="fa fa-4x fa-plus text-success"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>













            <!-- Technologies Carousel Section -->
            <section class="py-24 px-6">
                <div class="container mx-auto max-w-5xl">
                    <div class="text-center mb-16 fade-in">
                        <span
                            class="inline-block px-4 py-1.5 bg-green-100/50 dark:bg-green-900/20 text-green-600 dark:text-green-600 text-sm font-medium rounded-full mb-4"
                            >Nuestras Sucursales</span
                        >
                        <h2 class="text-3xl font-light mb-6 tracking-tight">
                            Conoce Nuestras Farmacias
                        </h2>
                        <p
                            class="max-w-2xl mx-auto text-gray-600 dark:text-gray-300 font-light"
                        >
                            Ofrecemos atención farmacéutica personalizada en
                            cada una de nuestras sucursales, brindando productos
                            de calidad y el mejor servicio para tu bienestar.
                        </p>
                    </div>

                    <!-- Tech Icons Carousel -->
                    <div class="tech-carousel-container">
                        <!-- Carousel Items -->
                        <div
                            class="tech-item"
                            v-for="(tech, index) in technologies"
                            :key="index"
                            :style="{
                                transform: `translateX(-${
                                    currentIndex * 100
                                }%)`,
                            }"
                        >
                            <div class="icon-container2">
                                <img
                                    :src="tech.imgSrcLight"
                                    :alt="tech.name"
                                    class="tech-icon"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Navigation buttons -->
                    <div class="carousel-nav">
                        <button class="prev-btn" @click="moveCarousel('prev')">
                            ❮
                        </button>
                        <button class="next-btn" @click="moveCarousel('next')">
                            ❯
                        </button>
                    </div>
                </div>
            </section>



            <!-- Colaboradores Destacados -->
            <section class="py-24 px-6 bg-gray-50 dark:bg-gray-900/30">
                <div class="container mx-auto max-w-5xl">
                    <div class="text-center mb-16 fade-in">
                        <span
                            class="inline-block px-4 py-1.5 bg-blue-100/50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-600 text-sm font-medium rounded-full mb-4"
                        >
                            Reconocimiento Interno
                        </span>
                        <h2 class="text-3xl font-light mb-6 tracking-tight">
                            Mejores
                            <span class="text-blue-600 dark:text-blue-600"
                                >Colaboradores</span
                            >
                            - Distrisol
                        </h2>
                        <p
                            class="max-w-2xl mx-auto text-gray-600 dark:text-gray-300 font-light"
                        >
                            Mes de Octubre – Felicitamos el compromiso, esfuerzo
                            y vocación de nuestros talentos.
                        </p>
                    </div>

                    <!-- Carousel manual (Vue) -->
                    <div
                        class="relative overflow-hidden rounded-2xl shadow-2xl fade-in h-[500px]"
                    >
                        <div
                            v-for="(collaborator, index) in collaborators"
                            :key="index"
                            class="absolute inset-0 transition-all duration-1000 flex flex-col items-center justify-center text-center px-4"
                            :class="
                                currentSlide === index
                                    ? 'opacity-100 z-10'
                                    : 'opacity-0 z-0'
                            "
                        >
                            <img
                                :src="collaborator.img"
                                :alt="collaborator.name"
                                class="rounded-full h-48 w-48 object-cover shadow-xl mb-6 border-4 border-white dark:border-gray-800"
                            />
                            <h3 class="text-xl font-semibold uppercase mb-1">
                                {{ collaborator.name }}
                            </h3>
                            <p class="uppercase text-blue-600 font-medium">
                                {{ collaborator.position }}
                            </p>
                            <p
                                class="text-gray-600 dark:text-gray-300 font-light mt-2"
                            >
                                {{ collaborator.location }}
                            </p>
                        </div>

                        <!-- Navigation -->
                        <button
                            @click="prevSlide"
                            class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/70 dark:bg-gray-800/70 flex items-center justify-center text-gray-800 dark:text-white hover:bg-white/90 dark:hover:bg-gray-700 transition-all duration-300 shadow-lg"
                        >
                            <i
                                class="pi pi-chevron-left text-white text-lg"
                            ></i>
                        </button>
                        <button
                            @click="nextSlide"
                            class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/70 dark:bg-gray-800/70 flex items-center justify-center text-gray-800 dark:text-white hover:bg-white/90 dark:hover:bg-gray-700 transition-all duration-300 shadow-lg"
                        >
                            <i
                                class="pi pi-chevron-right text-white text-lg"
                            ></i>
                        </button>

                        <!-- Dots -->
                        <div
                            class="absolute bottom-6 left-0 right-0 flex justify-center gap-3 z-20"
                        >
                            <button
                                v-for="(_, index) in collaborators"
                                :key="index"
                                @click="currentSlide = index"
                                class="w-3 h-3 rounded-full"
                                :class="
                                    currentSlide === index
                                        ? 'bg-blue-600'
                                        : 'bg-gray-400 dark:bg-gray-700'
                                "
                            ></button>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="py-12 border-t border-gray-200 dark:border-gray-900/50 px-6">
                <div class="container mx-auto max-w-5xl">
                    <div
                        class="flex flex-col md:flex-row justify-between "
                    >
                        <!-- Información de la farmacia -->
                        <div class="mb-8 md:mb-0 p-4">
                            <h3 class="text-2xl font-light mb-2">
                                <span class="text-blue-600 dark:text-blue-600"
                                    >Farmacia</span
                                >
                                <span class="text-gray-900 dark:text-white"
                                    >Solidaria</span
                                >
                            </h3>
                            <p
                                class="text-gray-600 dark:text-gray-300 font-light"
                            >
                                Urb. Galilea Monteverde Mz P Lote 1 / Piura -
                                Castilla
                            </p>
                            <p
                                class="text-gray-600 dark:text-gray-300 font-light"
                            >
                                Teléfono: 99999999
                            </p>
                            <p
                                class="text-gray-600 dark:text-gray-300 font-light"
                            >
                                Email: informatica@farmaciassolidaria.com
                            </p>
                        </div>

                        <!-- Redes Sociales con PrimeVue Icons -->
                        <div class="mb-8 md:mb-0 p-4">
                            <p
                                class="text-gray-600 dark:text-gray-300 font-light mb-2"
                            >
                                Conoce más sobre nosotros en nuestras redes
                                sociales
                            </p>
                            <h6 class="text-uppercase text-gray-600 py-2">
                                Síguenos en:
                            </h6>
                            <div class="d-flex justify-content-start">
                                <a
                                    class="btn btn-lg btn-success btn-lg-square mr-2"
                                    href="https://twitter.com/"
                                    target="_blank"
                                >
                                    <i class="pi pi-twitter"></i>
                                </a>
                                <a
                                    class="btn btn-lg btn-success btn-lg-square mr-2"
                                    href="https://www.facebook.com/FarmaciaSolidadria"
                                    target="_blank"
                                >
                                    <i class="pi pi-facebook"></i>
                                </a>
                                <a
                                    class="btn btn-lg btn-success btn-lg-square mr-2"
                                    href="https://www.instagram.com/"
                                    target="_blank"
                                >
                                    <i class="pi pi-instagram"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Enlaces de Interés con ShadCN Icons -->
                        <div class="mb-8 md:mb-0 p-4">
                            <h4 class="text-uppercase text-gray-600 mb-4">
                                Enlaces de Interés
                            </h4>
                            <a
                                href="https://www.digemid.minsa.gob.pe/"
                                target="_blank"
                                class="navbar-brand text-secondary"
                            >
                                <img
                                    alt="Digemid"
                                    src="images/landing/system/digemid.png"
                                    class="img-fluid mt-5 mt-lg-0"
                                    width="200"
                                    height="100"
                                />
                            </a>
                            <a
                                href="http://www.cqfp.pe/"
                                target="_blank"
                                class="navbar-brand text-secondary"
                            >
                                <img
                                    alt="CFP"
                                    src="images/landing/system/cfp.png"
                                    class="img-fluid mt-5 mt-lg-0"
                                    width="200"
                                    height="100"
                                />
                            </a>
                            <a
                                href="https://www.gob.pe/minsa"
                                target="_blank"
                                class="navbar-brand text-secondary"
                            >
                                <img
                                    alt="MDS"
                                    src="images/landing/system/mds.png"
                                    class="img-fluid mt-5 mt-lg-0"
                                    width="200"
                                    height="100"
                                />
                            </a>
                            <a
                                href="https://www.sunat.gob.pe/"
                                target="_blank"
                                class="navbar-brand text-secondary"
                            >
                                <img
                                    alt="Sunat"
                                    src="images/landing/system/sunat.png"
                                    class="img-fluid mt-5 mt-lg-0"
                                    width="200"
                                    height="100"
                                />
                            </a>
                        </div>

                        <!-- Correo Corporativo con PrimeVue Icon -->
                        <div class="mb-8 md:mb-0 p-4">
                            <h4 class="text-uppercase text-gray-600 mb-4">
                                Correo Corporativo
                            </h4>
                            <a
                                href="https://www.farmaciassolidaria.com:2096/"
                                target="_blank"
                                class="navbar-brand text-secondary"
                            >
                                <img
                                    title="Correo Solidaria"
                                    alt="Correo Web"
                                    src="images/landing/system/webmail.png"
                                    class="img-fluid mt-5 mt-lg-0"
                                    style="width: 200px; height: 50px"
                                />
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="border-t border-gray-200 dark:border-gray-900/50 mt-8 pt-8 text-center text-gray-500 dark:text-gray-400 font-light text-sm"
                >
                    © 2025 Farmacia Solidaria. Todos los derechos reservados.
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    name: "WelcomeView",
    data() {
        return {
            isDarkMode: false,
            currentSlide: 0,
            currentIndex: 0,
            activeFilter: '*',
            brands: [
            { name: 'Aprende', category: 'first', imgSrc: 'images/landing/system/aprende.png' },
            { name: 'Clorursol', category: 'second', imgSrc: 'images/landing/system/clorursol.png' },
            { name: 'Gestasol', category: 'first', imgSrc: 'images/landing/system/gestasol.png' },
            { name: 'Inmunosol', category: 'second', imgSrc: 'images/landing/system/inmunosol.png' },
            { name: 'Pulmonosol', category: 'second', imgSrc: 'images/landing/system/pulmonosol.png' },
            { name: 'Artrisol', category: 'first', imgSrc: 'images/landing/system/artrisol.png' }
        ],
        filteredItems: [],
            systemFeatures: [
                {
                    icon: "fas fa-chart-line",
                    title: "Analytics de Alto Rendimiento",
                    description:
                        "Monitoreo inteligente de servicios en tiempo real con visualizaciones interactivas para decisiones estratégicas.",
                },
                {
                    icon: "fas fa-users-cog",
                    title: "Gestión Integral de Clientes",
                    description:
                        "Sistema CRM avanzado para optimizar relaciones comerciales con segmentación personalizada.",
                },
                {
                    icon: "fas fa-server",
                    title: "Administración de Infraestructura",
                    description:
                        "Control centralizado con monitoreo continuo y alertas predictivas para mantener rendimiento óptimo.",
                },
                {
                    icon: "fas fa-shield-alt",
                    title: "Seguridad Empresarial Avanzada",
                    description:
                        "Protección multinivel con encriptación de última generación y autenticación biométrica.",
                },
                {
                    icon: "fas fa-code-branch",
                    title: "Desarrollo y Control de Proyectos",
                    description:
                        "Metodologías ágiles con seguimiento en tiempo real y control de versiones integrado.",
                },
                {
                    icon: "fas fa-file-invoice-dollar",
                    title: "Sistema Financiero Automatizado",
                    description:
                        "Facturación inteligente con múltiples pasarelas de pago y reportes personalizables.",
                },
            ],
            featureSlides: [
                {
                    title: "Desarrollo de Software Exclusivo",
                    description:
                        "Creamos soluciones digitales de alto rendimiento adaptadas perfectamente a los procesos únicos de su organización.",
                    bgClass:
                        "bg-gradient-to-r from-blue-700 to-blue-800 dark:from-blue-800 dark:to-blue-900",
                    features: [
                        "Aplicaciones empresariales de alto rendimiento",
                        "Interfaces elegantes y experiencias de usuario premium",
                        "Arquitectura escalable con tecnologías de vanguardia",
                    ],
                    imgWidth: 600,
                    imgHeight: 450,
                },
                {
                    title: "Infraestructura Cloud Premium",
                    description:
                        "Plataforma robusta y flexible para sus aplicaciones con monitoreo proactivo y soporte personalizado.",
                    bgClass:
                        "bg-gradient-to-r from-blue-700 to-blue-800 dark:from-blue-800 dark:to-blue-900",
                    features: [
                        "Entornos optimizados para máximo rendimiento",
                        "Arquitectura cloud de última generación",
                        "Garantía SLA de nivel empresarial",
                    ],
                    imgWidth: 600,
                    imgHeight: 450,
                },
                {
                    title: "Consultoría Estratégica de Elite",
                    description:
                        "Asesoramiento tecnológico por expertos del sector para transformar digitalmente su organización.",
                    bgClass:
                        "bg-gradient-to-r from-indigo-700 to-indigo-800 dark:from-indigo-800 dark:to-indigo-900",
                    features: [
                        "Análisis profundo de procesos e infraestructura",
                        "Estrategia digital personalizada para su sector",
                        "Optimización de recursos y retorno de inversión",
                    ],
                    imgWidth: 600,
                    imgHeight: 450,
                },
            ],
            collaborators: [
                {
                    name: "Mercedes Juliana Palomino Chunga",
                    position: "1° Puesto",
                    location: "Union Mercado",
                    img: "/images/collaborators/mercedes2.jpeg",
                },
                {
                    name: "Jessica Elsa Sarango Espinoza",
                    position: "2° Puesto",
                    location: "Chulucanas Plaza",
                    img: "/images/collaborators/jessica.jpeg",
                },
                {
                    name: "Danitza Vilchez Sernaque",
                    position: "3° Puesto",
                    location: "Plaza Catacaos",
                    img: "/images/collaborators/danitza2.jpeg",
                },
                {
                    name: "Jessica Elsa Sarango Espinoza",
                    position: "4° Puesto",
                    location: "Chulucanas Plaza",
                    img: "/images/collaborators/jessica.jpeg",
                },
            ],
            technologies: [
                {
                    name: "Sullana",
                    imgSrcLight: "/images/landing/system/sull.jpg",
                },
                {
                    name: "Chulucanas",
                    imgSrcLight: "/images/landing/system/chul.jpg",
                },
                {
                    name: "Union",
                    imgSrcLight: "/images/landing/system/uni.jpg",
                },
                {
                    name: "Piura",
                    imgSrcLight: "/images/landing/system/piura.jpg",
                },
                {
                    name: "Castilla",
                    imgSrcLight: "/images/landing/system/cast.jpg",
                },
            ],
        };
    },
    mounted() {
        // Autoplay for feature slides
        this.startAutoplay();
    this.updateFilteredItems();

        // Check for cookie first
        const savedMode = this.getCookie("appearance");
        if (savedMode) {
            this.isDarkMode = savedMode === "dark";
        }

        // Add animation classes
        this.animateOnScroll();
        window.addEventListener("scroll", this.animateOnScroll);
    },
    methods: {
        // Cookie management methods
        setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie =
                name +
                "=" +
                (value || "") +
                expires +
                "; path=/; SameSite=Strict";
        },

        getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(";");
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === " ") c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0)
                    return c.substring(nameEQ.length, c.length);
            }
            return null;
        },

        nextSlide() {
            this.currentSlide =
                (this.currentSlide + 1) % this.collaborators.length;
        },
        prevSlide() {
            this.currentSlide =
                (this.currentSlide - 1 + this.collaborators.length) %
                this.collaborators.length;
        },
        moveCarousel(direction) {
            const totalItems = this.technologies.length;
            const itemsPerSlide = 3; // Mover 3 elementos a la vez

            // Desplazarse al siguiente bloque de 3
            if (direction === "next") {
                // Si estamos en la última pantalla, volvemos al principio
                if (this.currentIndex + itemsPerSlide >= totalItems) {
                    this.currentIndex = 0;
                } else {
                    this.currentIndex = this.currentIndex + itemsPerSlide;
                }
            } else {
                // Si estamos en el principio, volvemos al final
                if (this.currentIndex - itemsPerSlide < 0) {
                    this.currentIndex = totalItems - itemsPerSlide;
                } else {
                    this.currentIndex = this.currentIndex - itemsPerSlide;
                }
            }
        },// Método para actualizar la lista de marcas filtradas
    updateFilteredItems() {
        if (this.activeFilter === '*') {
            this.filteredItems = this.brands;  // Muestra todas las marcas
        } else {
            this.filteredItems = this.brands.filter(brand => brand.category === this.activeFilter);  // Filtra por categoría
        }
    },

    // Método para manejar el cambio de filtro
    changeFilter(filter) {
        this.activeFilter = filter;  // Cambiar el filtro activo
        this.updateFilteredItems();  // Actualizar los elementos filtrados
    },
        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                this.nextSlide();
            }, 6000);
        },
        animateOnScroll() {
            const elements = document.querySelectorAll(".fade-in");
            elements.forEach((element) => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add("is-visible");
                }
            });
        },
    },
};
</script>

<style scoped>
/* Estilo para los filtros */
#portfolio-flters .active {
  background-color: #17a2b8;
  color: white;
}

/* Transición de fade para las secciones */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

/* Estilos para los elementos de la galería */
.portfolio-container {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  justify-content: center;
}

.portfolio-item img {
  width: 100%;
  height: 250px; /* Puedes ajustar el tamaño de las imágenes */
  object-fit: cover;
  transition: transform 0.3s ease-in-out;
}

.portfolio-item img:hover {
  transform: scale(1.05); /* Efecto de aumento al pasar el mouse */
}

.portfolio-btn {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: rgba(0, 0, 0, 0.5);
  padding: 10px;
  border-radius: 50%;
}

.portfolio-btn i {
  color: white;
  font-size: 2rem;
}

.portfolio-container {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  justify-content: center;
}

.portfolio-item {
  position: relative;
  overflow: hidden;
  border-radius: 8px;
}

.list-inline {
  display: inline-block;
}
/* Container for carousel */
.tech-carousel-container {
    display: flex;
    overflow: hidden;
    width: 100%;
}

/* Carousel Items */
.tech-item {
    flex: 0 0 33.33%; /* Show 3 items at once */
    transition: transform 0.5s ease;
    text-align: center;
}
.tech-item .icon-container2 {
    background-color: white;
    padding: 20px;
    margin-bottom: 10px;
    border-radius: 10px;
}
.tech-item .icon-container {
    background-color: white;
    padding: 20px;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.tech-item .tech-icon {
    width: 350px;
    height: auto;
    border-radius: 20px;
    object-fit: contain;
}

/* Navigation buttons */
.carousel-nav {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.prev-btn,
.next-btn {
    background-color: #17a2b8;
    border: none;
    color: white;
    font-size: 24px;
    padding: 10px 20px;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.prev-btn:hover,
.next-btn:hover {
    background-color: #138496;
}

/* Ensure responsiveness */
@media screen and (max-width: 768px) {
    .tech-item {
        flex: 0 0 50%; /* Show 2 items on smaller screens */
    }
}

@media screen and (max-width: 480px) {
    .tech-item {
        flex: 0 0 100%; /* Show 1 item on very small screens */
    }
}

/* Base styles */
.app-container {
    font-family: "Inter", sans-serif;
}

/* Dark mode */
.dark {
    color-scheme: dark;
}

/* Animation styles */
.fade-in {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 1s ease, transform 1s ease;
}

.fade-in.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* Stagger children animation */
.system-card:nth-child(1) {
    transition-delay: 0.1s;
}
.system-card:nth-child(2) {
    transition-delay: 0.2s;
}
.system-card:nth-child(3) {
    transition-delay: 0.3s;
}
.system-card:nth-child(4) {
    transition-delay: 0.4s;
}
.system-card:nth-child(5) {
    transition-delay: 0.5s;
}
.system-card:nth-child(6) {
    transition-delay: 0.6s;
}

/* Tech icon hover effect */
.tech-icon {
    transition: all 0.4s ease;
}

.tech-icon:hover {
    transform: translateY(-8px);
}

/* Custom transition for carousel */
.slide-leave-active,
.slide-enter-active {
    transition: all 1s;
}
.slide-enter {
    transform: translateX(100%);
    opacity: 0;
}
.slide-leave-to {
    transform: translateX(-100%);
    opacity: 0;
}
/* Estilo para las imágenes dentro de la galería */
.portfolio-item img {
    width: 100%;
    height: 250px; /* Tamaño fijo de las imágenes */
    object-fit: cover; /* Para que las imágenes no se deformen */
    transition: transform 0.3s ease-in-out;
}

.portfolio-item img:hover {
    transform: scale(1.05); /* Efecto de aumento al pasar el mouse */
}

.portfolio-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 0, 0, 0.5);
    padding: 10px;
    border-radius: 50%;
}

.portfolio-btn i {
    color: white;
    font-size: 2rem;
}

.portfolio-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}

.portfolio-item {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.list-inline{
display:inline-block;
}
</style>

<style scoped>
.app-container {
    font-family: "Inter", sans-serif;
}
.dark {
    color-scheme: dark;
}
.fade-in {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 1s ease, transform 1s ease;
}
.fade-in.is-visible {
    opacity: 1;
    transform: translateY(0);
}
</style>
