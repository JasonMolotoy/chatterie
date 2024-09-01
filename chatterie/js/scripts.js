$(document).ready(function(){
  $.ajax({
      url: '<?php echo SITEURL; ?>api/chats.php',
      method: 'GET',
      success: function(data) {
          var chats = JSON.parse(data);
          var chatList = $('#chat-list');
          chats.forEach(function(chat) {
              var chatHtml = `
                  <div class="col-md-4">
                      <div class="card mb-4">
                          <img src="<?php echo SITEURL; ?>images/chats/${chat.nom_image}" class="card-img-top" alt="${chat.nom}">
                          <div class="card-body">
                              <h5 class="card-title">${chat.nom}</h5>
                              <p class="card-text">${chat.description}</p>
                              <p class="card-text">Né(e) le ${chat.dateNaissance}</p>
                              <p class="card-text">${chat.prix}€</p>
                              <a href="<?php echo SITEURL; ?>commande.php?chat_id=${chat.id}" class="btn btn-primary">Réserver</a>
                          </div>
                      </div>
                  </div>
              `;
              chatList.append(chatHtml);
          });
      }
  });
});
