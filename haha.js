 // JavaScript Code
        const API_KEY = 'YOUR_API_KEY_HERE'; // Replace with your TMDB API key
        const API_BASE = 'https://api.themoviedb.org/3';
        const IMAGE_BASE = 'https://image.tmdb.org/t/p/w500';

        // Check if user is logged in
        if (localStorage.getItem('isLoggedIn') === 'true') {
            document.getElementById('landing').style.display = 'none';
            document.getElementById('mainApp').style.display = 'block';
        }

        // Show Login Modal
        function showLogin() {
            document.getElementById('loginModal').style.display = 'flex';
        }

        // Close Login Modal
        function closeLogin() {
            document.getElementById('loginModal').style.display = 'none';
        }

        // Login Form Handler
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            // Demo validation (replace with real auth)
            if (username === 'user' && password === 'pass') {
                localStorage.setItem('isLoggedIn', 'true');
                closeLogin();
                document.getElementById('landing').style.display = 'none';
                document.getElementById('mainApp').style.display = 'block';
            } else {
                alert('Invalid credentials. Try username: user, password: pass');
            }
        });

        // Logout
        function logout() {
            localStorage.removeItem('isLoggedIn');
            document.getElementById('mainApp').style.display = 'none';
            document.getElementById('landing').style.display = 'flex';
        }

        // Search Movies
        async function searchMovies() {
            const query = document.getElementById('searchInput').value.trim();
            if (!query) return;

            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = '<p style="text-align: center; grid-column: 1/-1;">Searching...</p>';

            try {
                const response = await fetch(`${API_BASE}/search/movie?api_key=${API_KEY}&query=${encodeURIComponent(query)}&language=en-US`);
                const data = await response.json();

                if (data.results && data.results.length > 0) {
                    resultsDiv.innerHTML = data.results.map(movie => `
                        <div class="movie-card" onclick="showMovieDetails(${movie.id})">
                            <img class="movie-poster" src="${movie.poster_path ? IMAGE_BASE + movie.poster_path : 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 300"><rect fill="%23333" width="200" height="300"/></svg>'}" alt="${movie.title}">
                            <div class="movie-info">
                                <div class="movie-title">${movie.title}</div>
                                <div class="movie-rating">⭐ ${movie.vote_average}/10</div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    resultsDiv.innerHTML = '<p style="text-align: center; grid-column: 1/-1;">No movies found. Try another search!</p>';
                }
            } catch (error) {
                resultsDiv.innerHTML = '<p style="text-align: center; grid-column: 1/-1;">Error fetching movies. Check your API key!</p>';
                console.error(error);
            }
        }

        // Show Movie Details (fetches full details)
        async function showMovieDetails(movieId) {
            try {
                const response = await fetch(`${API_BASE}/movie/${movieId}?api_key=${API_KEY}&language=en-US`);
                const movie = await response.json();

                document.getElementById('modalPoster').src = movie.poster_path ? IMAGE_BASE + movie.poster_path : 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400"><rect fill="%23333" width="300" height="400"/></svg>';
                document.getElementById('modalTitle').textContent = movie.title;
                document.getElementById('modalRating').textContent = `⭐ ${movie.vote_average}/10`;
                document.getElementById('modalOverview').textContent = movie.overview || 'No overview available.';
                document.getElementById('movieModal').style.display = 'flex';
            } catch (error) {
                console.error(error);
                alert('Error loading movie details.');
            }
        }

        // Close Movie Modal
        function closeMovieModal() {
            document.getElementById('movieModal').style.display = 'none';
        }

        // Allow Enter key for search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchMovies();
            }
        });

        // Close modals on outside click
        window.onclick = function(event) {
            const loginModal = document.getElementById('loginModal');
            const movieModal = document.getElementById('movieModal');
            if (event.target === loginModal) closeLogin();
            if (event.target === movieModal) closeMovieModal();
        }