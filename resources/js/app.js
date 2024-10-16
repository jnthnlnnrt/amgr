import './bootstrap';

//Toastr
import '../../vendor/masmerise/livewire-toaster/resources/js'; 

//Preline
import 'preline'

//PowerGrid
import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import './../../vendor/power-components/livewire-powergrid/dist/tailwind.css'

document.addEventListener("livewire:navigated", ()=> {
    window.HSStaticMethods.autoInit();
});
