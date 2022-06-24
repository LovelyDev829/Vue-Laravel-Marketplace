<div id="delete-modal" class="modal fade">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{translate('Delete Confirmation')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <i class="la la-4x la-warning text-warning mb-4"></i>
                <p class="fs-18 fw-600 mb-1">{{ translate('Are you sure to delete this?') }}</p>
                <div>{{ translate('All data related to this will be deleted.') }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{translate('Cancel')}}</button>
                <a href="" id="delete-link" class="btn btn-primary mt-2">{{translate('Yes, Delete')}}</a>
            </div>
        </div>
    </div>
</div>