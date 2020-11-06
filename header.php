<div id="header">
  <a href="/"><div id="logo"></div></a>
  <div class="dropdown">
    <a href="production/edit/hirado"><div id="menupont" style="margin-left:20px; background-color:#1e85a6;">HÍRADÓ</div></a>
    <div class="dropdown-content" style="margin-left:20px; background-color:#1e85a6;">
      <a href="program/options/emptyform/?production=hirado">Új tükör létrehozása</a>
    </div>
  </div>
  <div class="dropdown">
    <a href="javascript:void(0)"><div id="menupont" style="background-color:#2196bc;">MŰSOR&nbsp;TÜKRÖK</div></a>
    <div class="dropdown-content" style="background-color:#2196bc;">
      <a href="production/edit/pecsikor">Pécsi Kör</a>
      <a href="production/edit/kozpont">Központ</a>
      <a href="production/edit/palya">Pálya</a>
	  <a href="production/edit/keptar">Képtár</a>
	  <a href="production/edit/hozam">Hozam</a>
	  <a href="production/edit/baranyagazdasaga">Baranya Gazdasága</a>
    </div>
  </div>
  <div class="dropdown">
    <a href="javascript:void(0)"><div id="menupont" style="background-color:#25a8d1;">HÍRÖSSZEFOGLALÓ&nbsp;KÉSZÍTÉSE</div></a>
    <div class="dropdown-content" style="background-color:#25a8d1;">
      <a href="production/edit/7nap">7 Nap</a>
      <a href="production/edit/pannonkronika">Pannon Krónika</a>
    </div>
  </div>
  <div class="dropdown">
    <a href="onair"><div id="menupont" style="background-color:#35b3db;">NAPI&nbsp;MŰSOR</div></a>
    <div class="dropdown-content" style="background-color:#35b3db;">
      <a href="showlist">Állandó műsorok</a>
    </div>
  </div>
  <div class="dropdown">
    <a href="javascript:void(0)"><div id="menupont" style="background-color:#25a8d1;">ELSZÁMOLÁS</div></a>
    <div class="dropdown-content" style="background-color:#25a8d1;">
      <a href="salary/otherworks/?user=<?php echo $user_online; ?>&date=<?php echo date("Y-m"); ?>">Egyéb elvégzett feladataim</a>
      <a href="salary/total/?user=<?php echo $user_online; ?>&date=<?php echo date("Y-m"); ?>">Összesítő</a>
    </div>
  </div>
  <div class="dropdown">
    <a href="javascript:void(0)"><div id="menupont" style="background-color:#2196bc;">GENERÁLÁS</div></a>
    <div class="dropdown-content" style="background-color:#2196bc;">
      <a href="javascript:void(0)">Reklámblokk</a>
	  <a href="javascript:void(0)">Futócsík</a>
	  <a href="javascript:void(0)">Hír a weboldalra</a>
    </div>
  </div>
  <span style="font-size:13px; margin-left:20px;">&#128512;&nbsp;Belépve:<br><b><?php echo $user_fullname; ?></b></span>
  <a href="logout.php"><div id="logout-icon" title="Kijelentkezés"></div></a>
</div>