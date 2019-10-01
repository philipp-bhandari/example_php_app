'use strict';

function addIp(parentDiv) {

    const newDiv = document.createElement('div'),
        table = document.querySelector('table.table');

    let inputsHtml = `
    <form method="post" action="?q=addip">
        <table class="table table-hover">
            <tr>
                <td>
                    <div class="input-group form-group">
                        <input class="form-control" type="text" name="new_ip" placeholder="IP"></div>
                </td>
                <td>
                    <div class="input-group form-group">
                        <input class="form-control" type="text" name="new_port" placeholder="Port"></div>
                </td>
                <td>
                    <button type="submit" class="btn btn-dark">Сохранить</button>
                </td>
            </tr>
        </table>
    </form>
    `;

    newDiv.innerHTML = inputsHtml;
    parentDiv.insertBefore(newDiv, table);
}

function addUser(tableBody) {

}

function load() {
    const addIpButton = document.querySelector('.btn-dark'),
        table = document.querySelector('table.table');

    // Добавление полей для новых IP / Пользователя
    if(addIpButton){
        addIpButton.addEventListener('click', (e)=>{
            let action = e.target.dataset.action;

            if(action) {
                e.preventDefault();
                const parentDiv = document.querySelector('.container-fluid');

                if(action === 'add_ip') {
                    addIp(parentDiv);
                    addIpButton.style.display = 'none';
                }
                else if(action === 'add_user') {
                    addUser(parentDiv);
                }
            }
        });
    }

    // Управляющие кнопки Изменить / Удалить элемент
    if(table){
        table.addEventListener('click', (e)=>{
            e.preventDefault();
            let target = e.target;

            if(target.tagName === 'IMG') {
                target = target.parentElement;
            }

            if(target.tagName === 'A') {
                const parentTd = target.parentElement,
                    parentTr = parentTd.parentElement;

                if (target.tagName === 'A' && target.dataset.action === 'edit') {
                        const firstTd = parentTr.firstElementChild,
                        secondTd = firstTd.nextElementSibling;

                    let firstTdText = firstTd.innerText,
                        secondTdText = secondTd.innerText;

                    parentTd.innerHTML = "<button class='btn btn-dark edit'>Сохранить</button>";
                    firstTd.innerHTML = `<input name="ip_change" data-id='${target.dataset.id}' type='text' value='${firstTdText}'>`;
                    secondTd.innerHTML = `<input name="port_change" data-id='${target.dataset.id}' type='text' value='${secondTdText}'>`;

                    let saveButton = parentTd.querySelector('button.edit');
                    saveButton.addEventListener('click', (e)=>{
                        e.preventDefault();
                        const data = new FormData();
                        let newIp = firstTd.querySelector('input').value,
                            newPort = secondTd.querySelector('input').value;

                        data.append('id', target.dataset.id);
                        data.append('ip_change', newIp);
                        data.append('port_change', newPort);

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '/ports/async_handler.php');
                        xhr.send(data);
                        xhr.onreadystatechange = function() {
                            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                                console.log(xhr.responseText);
                                if(xhr.responseText === 'success') {
                                    saveButton.disabled = 'disabled';
                                    firstTd.innerHTML = newIp;
                                    secondTd.innerHTML = newPort;
                                } else {
                                    alert(xhr.responseText);
                                }
                            }
                        }
                    });
                } else if(target.tagName === 'A' && target.dataset.action === 'delete') {
                    console.log(parentTr);
                    let id = target.dataset.id;
                    const data = new FormData();
                    data.append('delete_ip', id);
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/ports/async_handler.php');
                    xhr.send(data);
                    xhr.onreadystatechange = function() {
                        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            console.log(xhr.responseText);
                            if(xhr.responseText === 'success') {
                                parentTr.remove()
                            } else {
                                alert(xhr.responseText);
                            }
                        }
                    }
                }
            }
        });
    }


















}

document.addEventListener('DOMContentLoaded', load);
