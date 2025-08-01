<div class="right">
    <div class="top">
        <button id="menu-btn">
            <span class="material-icons-sharp">menu</span>
        </button>
        <div class="theme-toggler">
            <span class="material-icons-sharp active">light_mode</span>
            <span class="material-icons-sharp">dark_mode</span>
        </div>
        <div class="profile">
            <div class="info">
                <p>Hey, <b>Tom</b></p>
                <small class="text-muted">Admin</small>
            </div>

            <div class="profile-photo">
                <img src="{{ asset('img/profile-photo.jpg') }}" alt="Profile Photo">
            </div>
        </div>
    </div>

    <div class="recent-updates">
        <h2>Recent Updates</h2>
        <div class="updates">
            <div class="update">
                <div class="profile-photo">
                    <img src="{{ asset('img/profile-1.jpg') }}" alt="Profile 1">
                </div>
                <div class="message">
                    <p><b>Dexter Morgan</b> Tonight's the night..</p>
                    <small class="text-muted">2 Minutes Ago</small>
                </div>
            </div>

            <div class="update">
                <div class="profile-photo">
                    <img src="{{ asset('img/profile-2.jpg') }}" alt="Profile 2">
                </div>
                <div class="message">
                    <p><b>John Snow</b> Telling the Truth Is Doing the Right Thing, Even Though It Is Not Always Easy.</p>
                    <small class="text-muted">49 Minutes Ago</small>
                </div>
            </div>

            <div class="update">
                <div class="profile-photo">
                    <img src="{{ asset('img/profile-3.jpg') }}" alt="Profile 3">
                </div>
                <div class="message">
                    <p><b>Tony Stark</b> The truth is... I am Iron Man</p>
                    <small class="text-muted">30 Minutes Ago</small>
                </div>
            </div>
        </div>
    </div>

    <div class="sales-analytics">
        <h2>Sales Analytics</h2>

        <div class="item online">
            <div class="icon">
                <span class="material-icons-sharp">shopping_cart</span>
            </div>
            <div class="right">
                <div class="info">
                    <h3>ONLINE ORDERS</h3>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <h5 class="success">+39%</h5>
                <h3>3849</h3>
            </div>
        </div>

        <div class="item offline">
            <div class="icon">
                <span class="material-icons-sharp">local_mall</span>
            </div>
            <div class="right">
                <div class="info">
                    <h3>OFFLINE ORDERS</h3>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <h5 class="danger">-17%</h5>
                <h3>1100</h3>
            </div>
        </div>

        <div class="item customers">
            <div class="icon">
                <span class="material-icons-sharp">person</span>
            </div>
            <div class="right">
                <div class="info">
                    <h3>NEW CUSTOMERS</h3>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <h5 class="success">+25%</h5>
                <h3>849</h3>
            </div>
        </div>

        <div class="item add-product">
            <div>
                <span class="material-icons-sharp">add</span>
                <h3>Add Product</h3>
            </div>
        </div>
    </div>
</div>
