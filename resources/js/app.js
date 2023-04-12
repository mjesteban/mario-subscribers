require('./bootstrap');

import DataTable from 'datatables.net-bs5';
import 'datatables.net-fixedheader-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-scroller-bs5';

const table = new DataTable('#subscribers', {
    responsive: true,
    processing: true,
    serverSide: true,
    pagingType: 'simple',
    previous: 'links.prev',
    next: 'links.next',
    ajax: 'ml/subscribers',
    lengthMenu: [10, 25, 50, 100, 250, 500, 1000],
    pageLength: 10,
    columns: [
        {
            data: null,
            sortable: false,
            render: (data, type, row) =>
                `<button href="#" data-id="${row.id}" class="btn btn-outline-danger delete-btn"><i class="bi bi-person-x-fill"></i>&nbsp;Bye!</button>`,
        },
        {
            data: 'email',
            sortable: false,
            render: (data, type, row) => {
                if (type === 'display') {
                    return `<a href="subscribers/${row.id}/edit" class="text-decoration-none"><i class="bi bi-pencil-square"></i> ${data}</a>`;
                }

                return data;
            },
        },
        {
            data: 'fields.name',
            sortable: false,
            render: (data, type, row) =>
                `${row.fields.name} ${row.fields.last_name}`,
        },
        { data: 'fields.country', sortable: false },
        {
            data: null,
            sortable: false,
            render: (data, type, row) => {
                const date = new Date(row.subscribed_at);

                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();

                return `${day}/${month}/${year}`;
            },
        },
        {
            data: null,
            sortable: false,
            render: (data, type, row) => {
                const date = new Date(row.subscribed_at);

                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const seconds = String(date.getSeconds()).padStart(2, '0');

                return `${hours}:${minutes}:${seconds}`;
            },
        },
    ],
});

const deleteSubscriber = async (id) => {
    try {
        await fetch(`subscribers/${id}`, {
            method: 'DELETE',
        });

        table.ajax.reload();
    } catch (e) {
        console.error(e);
    }
};

document.addEventListener('click', (event) => {
    if (event.target.classList.contains('delete-btn')) {
        const id = event.target.dataset.id;
        deleteSubscriber(id);
    }
});