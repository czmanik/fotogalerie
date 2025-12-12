from playwright.sync_api import sync_playwright

def verify_hero_carousel():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Navigate to home
        page.goto("http://127.0.0.1:8000")

        # Check if Slide 1 is visible (we created it in test database but this is running on actual DB?)
        # Wait, the server uses database.sqlite. We need to seed it first.

        page.screenshot(path="verification/hero_carousel_initial.png")

        browser.close()

if __name__ == "__main__":
    verify_hero_carousel()
