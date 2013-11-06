<div class="dashboard">
    <ul>
        <li id="dashboard-timetable-box" class="ld-box ld-timetable red">
            <div class="ld-box-head">
                <div id="dashboard-timetable-head" class="title"> 
                    <h2><span class="custom-icon-timetable"></span>{{ t._("timetable") }}</h2>
                </div>
            </div>
            <div class="ld-box-child">
                <div id="dashboard-timetable-contents">
                    <div class="header-navigation">
                        <a title="Prev" class="default-prev"><span class="icon-chevron-sign-left"></span></a>
                        <a title="Next" class="default-next"><span class="icon-chevron-sign-right"></span></a>
                        <h3></h3>
                    </div>
                </div>
            </div>
        </li>
        <li id="dashboard-homework-box" class="ld-box ld-homework orange">
            <div class="ld-box-head">
                <div id="dashboard-homework-head" class="title"> 
                    <h2><span class="custom-icon-homework"></span>{{ t._("homework") }}</h2>
                </div>
            </div>
            <div class="ld-box-child">
                <div id="dashboard-homework-contents"></div>
            </div>
        </li>
        <li id="dashboard-events-box" class="ld-box ld-events purple">
            <div class="ld-box-head">
                <div id="dashboard-events-head" class="title"></div>
            </div>
            <div class="ld-box-child">
                <div id="dashboard-events"></div>
            </div>
        </li>
        <li id="dashboard-messages-box" class="ld-box messages green">
            <div class="ld-box-head">
                <div id="dashboard-messages-head "class="title">
                    <h2><span class="icon-envelope"></span>{{ t._("messages") }}</h2>
                </div>
            </div>
            <div class="ld-box-child">
                <div id="dashboard-messages-contents"></div>
            </div>
        </li>
        <li id="dashboard-notices-box" class="ld-box ld-notices blue">
            <div class="ld-box-head">
                <div id="dashboard-notices-head" class="title">
                    <h2><span classs="custom-icon-notices"></span>{{ t._("notices") }}</h2>
                </div>
            </div>
            <div class="ld-box-child">
                <div id="dashboard-notices"></div>
            </div>
        </li>
    </ul>
</div>
