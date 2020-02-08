    <script>
        var Render = <?php echo $render ?>;
    </script>
    <div id="app">
        <div class="container">
            <div class="navigation">
                <div class="navigation-menu">
                    <div class="navigation-menu-item" :class="{'active' : isActive('dashboard') || isActive('contact')}">
                        <router-link :to="{name: 'dashboard'}">Рабочий стол</router-link>
                    </div>
                    <div class="navigation-menu-item" :class="{'active' : isActive('contacts') || isActive('contact')}">
                        <router-link :to="{name: 'contacts'}">Контакты</router-link>
                    </div>
                    <div class="navigation-menu-item" :class="{'active' : isActive('leads') || isActive('lead')}">
                        <router-link :to="{name: 'leads'}">Сделки</router-link>
                    </div>
                </div>
                <div class="navigation-actions">
                    <div class="navigation-actions-item">
                        <div class="button black small">
                            <button @click="toggleTheme()">
                                &#9728;
                                <!-- <ion-icon name="moon"></ion-icon> -->
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <transition name="slide-fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </div>
    </div>