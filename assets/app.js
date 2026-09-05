const sidebar=document.querySelector('#sidebar');
document.querySelector('#menuBtn')?.addEventListener('click',()=>sidebar.classList.toggle('open'));
document.querySelectorAll('[data-modal]').forEach(button=>button.addEventListener('click',()=>document.querySelector('#'+button.dataset.modal).classList.add('open')));
document.querySelectorAll('.close,.close-action').forEach(button=>button.addEventListener('click',()=>button.closest('.modal-wrap').classList.remove('open')));
document.querySelectorAll('.modal-wrap').forEach(modal=>modal.addEventListener('click',event=>{if(event.target===modal)modal.classList.remove('open')}));
document.querySelector('form')?.addEventListener('submit',event=>{event.preventDefault();event.target.closest('.modal-wrap').classList.remove('open')});
