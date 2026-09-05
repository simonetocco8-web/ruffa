const sidebar=document.querySelector('#sidebar');
document.querySelector('#menuBtn')?.addEventListener('click',()=>sidebar.classList.toggle('open'));
document.querySelectorAll('[data-modal]').forEach(button=>button.addEventListener('click',()=>{
  const modal=document.querySelector('#'+button.dataset.modal);
  modal?.classList.add('open');
  modal?.querySelector('input,select')?.focus();
}));
document.querySelectorAll('.close,.close-action').forEach(button=>button.addEventListener('click',()=>button.closest('.modal-wrap').classList.remove('open')));
document.querySelectorAll('.modal-wrap').forEach(modal=>modal.addEventListener('click',event=>{if(event.target===modal)modal.classList.remove('open')}));
document.querySelectorAll('.modal-wrap form').forEach(form=>form.addEventListener('submit',event=>{
  event.preventDefault();
  event.target.closest('.modal-wrap').classList.remove('open');
}));

document.querySelector('#newUserForm')?.addEventListener('submit',event=>{
  const data=new FormData(event.currentTarget);
  const escape=value=>{const node=document.createElement('span');node.textContent=value;return node.innerHTML};
  document.querySelector('#usersTableBody')?.insertAdjacentHTML('beforeend',`<tr><td><b>${escape(data.get('first_name'))} ${escape(data.get('last_name'))}</b></td><td>${escape(data.get('email'))}</td><td>${escape(data.get('phone'))}</td><td>${escape(data.get('role'))}</td><td><button aria-label="Azioni">•••</button></td></tr>`);
  event.currentTarget.reset();
  const toast=document.querySelector('#toast');
  toast.classList.add('show');
  setTimeout(()=>toast.classList.remove('show'),2800);
});

document.addEventListener('keydown',event=>{
  if(event.key==='Escape') document.querySelector('.modal-wrap.open')?.classList.remove('open');
});
