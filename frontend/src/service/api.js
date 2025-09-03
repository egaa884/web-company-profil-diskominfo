import axios from 'axios';

// Create an axios instance with default configuration
const apiClient = axios.create({
  baseURL: import.meta?.env?.VITE_API_BASE_URL || 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  timeout: 30000, // 30 detik timeout
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
    } else if (error.code === 'ECONNABORTED') {
      console.error('Request timeout. Server mungkin lambat atau tidak merespons.');
    } else if (error.response?.status === 500) {
      console.error('Server error (500). Ada masalah di backend.');
    } else if (error.response?.status === 404) {
      console.error('Endpoint tidak ditemukan (404).');
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
  },
  
  // Get a specific berita by slug
  async getBeritaBySlug(slug) {
    try {
      const response = await apiClient.get(`/berita/slug/${slug}`);
      return response;
    } catch (error) {
      console.error('Error fetching berita by slug:', error);
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

export const laporanPengaduanService = {
  // Get all laporan pengaduan with pagination and filters
  async getAllLaporanPengaduan(params = {}) {
    const maxRetries = 3;
    let lastError;
    
    for (let attempt = 1; attempt <= maxRetries; attempt++) {
      try {
        console.log(`Attempt ${attempt} to fetch laporan pengaduan`);
        const response = await apiClient.get('/laporan-pengaduan', { params });
        return response;
      } catch (error) {
        lastError = error;
        console.error(`Error fetching laporan pengaduan (attempt ${attempt}):`, error);
        
        if (attempt < maxRetries) {
          // Wait before retrying (exponential backoff)
          await new Promise(resolve => setTimeout(resolve, 1000 * attempt));
        }
      }
    }
    
    throw lastError;
  },
  
  // Get laporan pengaduan by ID
  async getLaporanPengaduanById(id) {
    try {
      const response = await apiClient.get(`/laporan-pengaduan/${id}`);
      return response;
    } catch (error) {
      console.error('Error fetching laporan pengaduan by ID:', error);
      throw error;
    }
  },
  
  // Get categories
  async getCategories() {
    try {
      const response = await apiClient.get('/laporan-pengaduan/categories');
      return response;
    } catch (error) {
      console.error('Error fetching categories:', error);
      throw error;
    }
  },
  
  // Get statistics
  async getStatistics() {
    try {
      const response = await apiClient.get('/laporan-pengaduan/statistics');
      return response;
    } catch (error) {
      console.error('Error fetching statistics:', error);
      throw error;
    }
  },
  
  // Create new laporan pengaduan
  async createLaporanPengaduan(data) {
    try {
      const response = await apiClient.post('/laporan-pengaduan', data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      return response;
    } catch (error) {
      console.error('Error creating laporan pengaduan:', error);
      throw error;
    }
  }
};

// New service for admin-generated reports
export const laporanPengaduanAdminService = {
  // Get all admin-generated reports with pagination and filters
  async getAllLaporanPengaduanAdmin(params = {}) {
    try {
      const response = await apiClient.get('/laporan-pengaduan-admin', { params });
      return response;
    } catch (error) {
      console.error('Error fetching admin laporan pengaduan:', error);
      throw error;
    }
  },
  
  // Get admin-generated report by ID
  async getLaporanPengaduanAdminById(id) {
    try {
      const response = await apiClient.get(`/laporan-pengaduan-admin/${id}`);
      return response;
    } catch (error) {
      console.error('Error fetching admin laporan pengaduan by ID:', error);
      throw error;
    }
  },
  
  // Get statistics for admin-generated reports
  async getStatistics() {
    try {
      const response = await apiClient.get('/laporan-pengaduan-admin/statistics');
      return response;
    } catch (error) {
      console.error('Error fetching admin statistics:', error);
      throw error;
    }
  },
  
  // Get available years
  async getYears() {
    try {
      const response = await apiClient.get('/laporan-pengaduan-admin/years');
      return response;
    } catch (error) {
      console.error('Error fetching years:', error);
      throw error;
    }
  },
  
  // Get available months
  async getMonths() {
    try {
      const response = await apiClient.get('/laporan-pengaduan-admin/months');
      return response;
    } catch (error) {
      console.error('Error fetching months:', error);
      throw error;
    }
  },
  
  // Get latest reports
  async getLatest(limit = 5) {
    try {
      const response = await apiClient.get('/laporan-pengaduan-admin/latest', { params: { limit } });
      return response;
    } catch (error) {
      console.error('Error fetching latest reports:', error);
      throw error;
    }
  },
  
  // Download file
  async downloadFile(id) {
    try {
      const response = await apiClient.get(`/laporan-pengaduan-admin/${id}/download`, {
        responseType: 'blob'
      });
      return response;
    } catch (error) {
      console.error('Error downloading file:', error);
      throw error;
    }
  }
};

// FAQ service
export const faqService = {
  async getFaqs(params = {}) {
    try {
      const response = await apiClient.get('/faqs', { params });
      return response;
    } catch (error) {
      console.error('Error fetching FAQs:', error);
      throw error;
    }
  }
};

// Chat service for AI chatbot
export const chatService = {
  async sendMessage(payload) {
    try {
      const response = await apiClient.post('/chat', payload);
      return response;
    } catch (error) {
      console.error('Error sending chat message:', error);
      throw error;
    }
  }
};

export default apiClient;