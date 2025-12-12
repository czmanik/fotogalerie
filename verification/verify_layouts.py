from playwright.sync_api import sync_playwright

def verify_hero_layouts():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Desktop
        page.set_viewport_size({"width": 1280, "height": 800})
        page.goto("http://127.0.0.1:8000")

        # Wait for slide 1
        page.wait_for_selector("text=Split Left Boxed")
        page.screenshot(path="verification/hero_layout_1_desktop.png")

        # Advance slide using a simpler selector (the second button in the control group is 'Next')
        # We can also rely on autoplay or just try to find the button by its position or content.
        # Let's try to click the right side of the screen or find the SVG by a simpler path or just index.
        # Finding the button that contains the 'next' arrow path.

        # Or simpler: The buttons are at the bottom. The last button in that container is 'Next'.
        page.locator("button").last.click()

        page.wait_for_timeout(1500) # Wait for transition
        page.screenshot(path="verification/hero_layout_2_desktop.png")

        # Advance slide
        page.locator("button").last.click()
        page.wait_for_timeout(1500)
        page.screenshot(path="verification/hero_layout_3_desktop.png")

        # Mobile
        page.set_viewport_size({"width": 375, "height": 812})
        page.goto("http://127.0.0.1:8000")
        page.wait_for_selector("text=Split Left Boxed")
        page.screenshot(path="verification/hero_layout_1_mobile.png")

        browser.close()

if __name__ == "__main__":
    verify_hero_layouts()
