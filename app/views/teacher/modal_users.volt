<div class="modal fade"
    id="modal{{ classList.id}}"
    role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Users</h4>
        </div>
        <div class="modal-body">
            {% for user in classList.users %}
                <p>{{ user.name }}</p>
            {% endfor %}
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>