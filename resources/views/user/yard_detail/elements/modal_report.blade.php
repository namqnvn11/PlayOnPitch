<div class="modal fade @if ($errors->any()) show @endif" id="modalReport" tabindex="-1" aria-labelledby="modalReportLabel" aria-hidden="true" @if ($errors->any()) style="display: block;" aria-modal="true" role="dialog" @endif>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReportLabel">Báo cáo bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reportForm" action="{{ route('user.yarddetail.report') }}" method="POST">
                    @csrf
                    <input type="hidden" name="rating_id" id="ratingId">
                    <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
                    <div class="form-group">
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" class="form-control rounded-md border-gray-400" placeholder="Nhập tiêu đề">
                        @error('title')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="comment" class="form-label">Lý do báo cáo:</label>
                        <textarea name="comment" id="comment" class="form-control rounded-md border-gray-400" rows="3" placeholder="Nhập lí do báo cáo"></textarea>
                        @error('comment')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('modalReport'));
            modal.show();
        });
    </script>
@endif
