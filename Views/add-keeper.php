<?php

require_once('nav-bar.php');

?>

<!-- ################################################################################################ -->
<div>
  <div>
    <div> 
      <ul>
        <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowAddView"?>">Home</a></li>
        <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowAddView"?>">Add Keeper</a></li>
        <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowListView"?>">List Keepers</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div>
    <main>
        <div>
            <h2>Becoming a new Keeper!</h2>
            <form action="<?php ECHO FRONT_ROOT . "Keeper/Add"?>" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>DNI</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <td style="max-width: 100px;">
                        <input type="text" name="firstName" min="1" max="999" size="30" required>
                        </td>
                        <td>
                        <input type="text" name="lastName" min="1" max="999" size="30" required>
                        </td>
                        <td>
                        <input type="text" name="dni" min="1" max="999" size="30" required>
                        </td>
                        <td>
                        <input type="email" name="email" min="1" max="999" size="30" required>
                        </td>
                        <td>
                        <input type="text" name="phoneNumber" min="1" max="999" size="30" required>
                        </td>
                    </tbody>
                </table>
                <div class="petSize-info">
                    <label for="petSize">Pet's size i'm willing to keep</label>
                    <input type="radio" name="small" value="small" checked/>
                    <label for="small">Small</label>
                    <input type="radio" name="medium" value="medium"/>
                    <label for="medium">Medium</label>
                    <input type="radio" name="big" value="big"/>
                    <label for="small">Big</label>
                </div>
                <div class="button">
                    <button type="submit" class="btn">Become a Keeper</button>
                </div>
            </form>
        </div>
    </main>
</div>
<!-- ################################################################################################ -->
