import axios from 'axios';

// Create an axios instance with default configuration
const apiClient = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  timeout: 10000, // 10 detik timeout
});

// Request interceptor untuk menangani request
apiClient.interceptors.request.use(
  (config) => {
    console.log('API Request:', config.method?.toUpperCase(), config.url);
    return config;
  },
  (error) => {
    console.error('API Request Error:', error);
    return Promise.reject(error);
  }
);

// Response interceptor untuk menangani response
apiClient.interceptors.response.use(
  (response) => {
    console.log('API Response:', response.status, response.config.url);
    return response;
  },
  (error) => {
    console.error('API Response Error:', error.response?.status, error.config?.url, error.message);
    
    // Handle specific error cases
    if (error.code === 'ECONNREFUSED') {
      console.error('Backend server tidak berjalan. Pastikan Laravel server sudah dijalankan di port 8000');
    }
    
    return Promise.reject(error);
  }
);

// API service functions
export const beritaService = {
  // Get latest 3 berita for the news section
  async getLatestBerita() {
    try {
      const response = await apiClient.get('/berita/latest');
      return response;
    } catch (error) {
      console.error('Error fetching latest berita:', error);
      throw error;
    }
  },
  
  // Get hot news
  async getHotNews() {
    try {
      const response = await apiClient.get('/berita/hot');
      return response;
    } catch (error) {
      console.error('Error fetching hot news:', error);
      throw error;
    }
  },
  
  // Get all berita with pagination and category filter
  async getAllBerita(params = {}) {
    try {
      const response = await apiClient.get('/berita', { params });
      return response;
    } catch (error) {
      console.error('Error fetching all berita:', error);
      throw error;
    }
  },
  
  // Get berita by category
  async getBeritaByCategory(category) {
    try {
      const response = await apiClient.get(`/berita/category/${category}`);
      return response;
    } catch (error) {
      console.error('Error fetching berita by category:', error);
      throw error;
    }
  },
  
  // Get all categories
  async getCategories() {
    try {
      const response = await apiClient.get('/berita/categories');
      return response;
    } catch (error) {
      console.error('Error fetching categories:', error);
      throw error;
    }
  },
  
  // Get a specific berita by ID
  async getBeritaById(id) {
    try {
      const response = await apiClient.get(`/berita/${id}`);
      return response;
    } catch (error) {
      console.error('Error fetching berita by ID:', error);
      throw error;
    }
  }
};

export const profilService = {
  // Get all profil data
  async getAllProfil(params = {}) {
    try {
      const response = await apiClient.get('/profil', { params });
      return response;
    } catch (error) {
      console.error('Error fetching all profil:', error);
      throw error;
    }
  },
  
  // Get profil by category
  async getProfilByCategory(kategori) {
    try {
      const response = await apiClient.get(`/profil/category/${kategori}`);
      return response;
    } catch (error) {
      console.error('Error fetching profil by category:', error);
      throw error;
    }
  },
  
  // Get all categories
  async getCategories() {
    try {
      const response = await apiClient.get('/profil/categories');
      return response;
    } catch (error) {
      console.error('Error fetching profil categories:', error);
      throw error;
    }
  },
  
  // Get all profil data grouped by category
  async getAllCategories() {
    try {
      const response = await apiClient.get('/profil/all-categories');
      return response;
    } catch (error) {
      console.error('Error fetching all profil categories:', error);
      throw error;
    }
  },
  
  // Get a specific profil by ID
  async getProfilById(id) {
    try {
      const response = await apiClient.get(`/profil/${id}`);
      return response;
    } catch (error) {
      console.error('Error fetching profil by ID:', error);
      throw error;
    }
  }
};

export default apiClient;