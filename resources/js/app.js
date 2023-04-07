require('./bootstrap');
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

let table = new DataTable('#subscribers', {
    responsive: true,
    processing: true,
    serverSide: false,
});