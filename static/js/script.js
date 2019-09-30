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

    // Управляющие кнопки Изменить / Удалить элемент
    table.addEventListener('click', (e)=>{
        e.preventDefault();
        let target = e.target;

        if(target.tagName === 'IMG') {
            target = target.parentElement;
        }
        if (target.tagName === 'A') {
            const parentTd = target.parentElement,
                parentTr = parentTd.parentElement,
                firstTd = parentTr.firstElementChild,
                secondTd = firstTd.nextElementSibling;

            let firstTdText = firstTd.innerText,
                secondTdText = secondTd.innerText;

            parentTd.innerHTML = "<button class='btn btn-dark'>Сохранить</button>";
            firstTd.innerHTML = `<input type='text' value='${firstTdText}'>`;
            secondTd.innerHTML = `<input type='text' value='${secondTdText}'>`;
        }
    });

















}

document.addEventListener('DOMContentLoaded', load);
