    <script>
        var CSFR = '<?php echo $this->request->csrfToken ?>';
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
            </div>
            <transition name="slide-fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </div>
    </div>