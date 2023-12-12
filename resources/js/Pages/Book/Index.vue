<template>
  <div class="book-container">
    <h1>Tabel Buku</h1>
    <button @click="showAddModal" class="add-button">Tambah Buku</button>

    <table>
      <thead class="table-head">
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th>Tahun Terbit</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(book, index) in books" :key="book.id">
          <td>{{ index + 1 }}</td>
          <td>{{ book.Judul }}</td>
          <td>{{ book.Penulis }}</td>
          <td>{{ book.Penerbit }}</td>
          <td>{{ book.Tahun_Terbit }}</td>
          <td class="aksi-btn">
            <button @click="showEditModal(book)" class="edit-button">Edit</button>
            <button @click="deleteBook(book.id)" class="delete-button">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- add book modal -->
    <div v-if="showModal && modalAction === 'Tambah'" class="modal">
      <div class="form-container">
        <button @click="hideModal" class="close-button">x</button>
        <form @submit.prevent="submitForm">
          <label>Judul</label>
          <input v-model="form.Judul" required>

          <label>Penulis</label>
          <input v-model="form.Penulis" required>

          <label>Penerbit</label>
          <input v-model="form.Penerbit" required>

          <label>Tahun Terbit</label>
          <input v-model="form.Tahun_Terbit" required>

          <button type="submit">Simpan</button>
        </form>
      </div>
    </div>
    <!-- edit book modal -->
    <div v-if="showModal && modalAction === 'Edit'" class="modal">
      <div class="form-container">
        <button @click="hideModal" class="close-button">x</button>
        <form @submit.prevent="submitForm">
          <label>Judul</label>
          <input v-model="form.Judul" required>

          <label>Penulis</label>
          <input v-model="form.Penulis" required>

          <label>Penerbit</label>
          <input v-model="form.Penerbit" required>

          <label>Tahun Terbit</label>
          <input v-model="form.Tahun_Terbit" required>

          <button type="submit">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';

export default {
  props: {
    data: Array,
  },
  setup(props) {
    const showModal = ref(false);
    const modalAction = ref('');
    const form = ref({
      id: null,
      Judul: '',
      Penulis: '',
      Penerbit: '',
      Tahun_Terbit: '',
    });

    const showAddModal = () => {
      showModal.value = true;
      modalAction.value = 'Tambah';
      resetForm();
    };

    const showEditModal = (book) => {
      showModal.value = true;
      modalAction.value = 'Edit';
      form.value = { ...book };
    };

    const hideModal = () => {
      showModal.value = false;
      resetForm();
    };

    const addBook = async () => {
      try {
        await axios.post('/book', form.value);
        hideModal();
        window.location.reload();
      } catch (error) {
        console.error('Error adding book:', error);
      }
    };

    const updateBook = async () => {
      try {
        await axios.put(`/book/${form.value.id}`, form.value);
        hideModal();
        window.location.reload();
      } catch (error) {
        console.error('Error updating book:', error);
      }
    };

    const removeBook = async (id) => {
      try {
        await axios.delete(`/book/${id}`);
      } catch (error) {
        console.error('Error deleting book:', error);
      }
    };

    const submitForm = () => {
      if (modalAction.value === 'Tambah') {
        addBook();
      } else if (modalAction.value === 'Edit') {
        updateBook();
      }
    };

    const deleteBook = (id) => {
      if (confirm('Are you sure you want to delete this book?')) {
        removeBook(id);
        window.location.reload();
      }
    };

    const resetForm = () => {
      form.value = {
        id: null,
        Judul: '',
        Penulis: '',
        Penerbit: '',
        Tahun_Terbit: '',
      };
    };

    return {
      showModal,
      modalAction,
      form,
      showAddModal,
      showEditModal,
      hideModal,
      submitForm,
      deleteBook,
      books: props.data || [],
    };
  },
};
</script>

<style scoped>
.book-container {
  max-width: 1000vw;
  margin: auto;
  padding: 40px;
}

h1 {
  text-align: center;
  font-size: 24px;
  font-weight: bold;
}

button {
  margin-bottom: 10px;
  padding: 8px 16px; 
  cursor: pointer;
}

.aksi-btn {
  display: flex;
  gap: 8px;
}

button.edit-button,
button.add-button {
  background-color: #3498db; 
  color: white;
}

button.delete-button {
  background-color: #e74c3c; 
  color: white;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
  text-align: center;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.form-container {
  max-width: 400px;
  margin: auto;
  background-color: white;
  padding: 20px;
  border-radius: 8px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
}

button[type="submit"] {
  background-color: #4caf50;
  color: white;
  padding: 10px;
  border: none;
  cursor: pointer;
  width: 50%;
}

button[type="submit"]:hover {
  background-color: #45a049;
}

.close-button {
  display: flex;
  width: 100%;
  justify-content: right;
  color: red;
  font-size: 30px;
  padding: 0px 10px 0px 0px;
}

.close-button:hover {
  font-weight: bold;
}
</style>
