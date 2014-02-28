<div class="row">
    <div class="small-11 columns small-centered">
        <p></p>
    <table>
      <thead>
        <tr>
          <th>T</th>
          <th>K</th>
          <th>G</th>
          <th>P</th>
          <th>A</th>
          <th>Ü</th>
          <th>M</th>
        </tr>
      </thead>
      <tbody>
          <?php
          echo getDays($UserData['ID'], 2);
          
//          $overview = new zeiten($UserData['ID']);
//          $overview->getMonth(2);
          ?>
      </tbody>
    </table>
    </div>
</div>

