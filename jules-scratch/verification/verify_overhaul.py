import re
from playwright.sync_api import sync_playwright, Page, expect
from faker import Faker

fake = Faker('pt_BR')

def run_verification(page: Page):
    """
    Main verification function to test the application overhaul.
    """
    # Generate fake user data
    user_name = fake.name()
    user_email = f"testuser_{fake.unix_time()}@example.com"
    user_password = fake.password(length=12, special_chars=True, digits=True, upper_case=True, lower_case=True)

    base_url = "http://localhost:8000"

    # --- 1. Registration ---
    print("Navigating to registration page...")
    page.goto(f"{base_url}/registo")

    expect(page.get_by_role("heading", name="Registo")).to_be_visible()

    print(f"Registering user: {user_name} ({user_email})")
    page.get_by_placeholder("Nome").fill(user_name)
    page.get_by_placeholder("Email").fill(user_email)

    # Fill passwords and test the toggle
    page.get_by_placeholder("Palavra-passe", exact=True).fill(user_password)
    page.get_by_placeholder("Confirmar Palavra-passe").fill(user_password)

    # Click the show/hide password button
    page.locator('.btn-toggle-password[data-target="palavra_passe"]').click()
    expect(page.get_by_placeholder("Palavra-passe", exact=True)).to_have_attribute("type", "text")

    # Take a screenshot of the registration form with password visible
    page.screenshot(path="jules-scratch/verification/01_registration_form.png")

    # Hide password again
    page.locator('.btn-toggle-password[data-target="palavra_passe"]').click()
    expect(page.get_by_placeholder("Palavra-passe", exact=True)).to_have_attribute("type", "password")

    # Submit registration
    page.get_by_role("button", name="Registar").click()

    # --- 2. Login ---
    print("Logging in...")
    # The app should redirect to the login page
    expect(page.get_by_role("heading", name="Login")).to_be_visible(timeout=10000)

    page.get_by_placeholder("Email").fill(user_email)
    page.get_by_placeholder("Palavra-passe").fill(user_password)

    # Test the loading spinner
    submit_button = page.get_by_role("button", name="Entrar")
    expect(submit_button.locator(".btn-spinner")).not_to_be_visible()
    submit_button.click()
    expect(submit_button.locator(".btn-spinner")).to_be_visible()

    # --- 3. Onboarding (if it appears) & Navigation ---
    print("Checking for onboarding...")
    try:
        # Check if we are on the onboarding page
        expect(page.get_by_role("heading", name="Bem-vindo ao Avançar!")).to_be_visible(timeout=5000)
        print("Onboarding page detected. Selecting default pillars...")
        page.get_by_role("button", name="Concluir Onboarding").click()
    except Exception:
        print("Onboarding page not found, proceeding from dashboard.")
        expect(page.get_by_role("heading", name="Dashboard")).to_be_visible(timeout=10000)

    # --- 4. Navigate to Página do Dia ---
    print("Navigating to 'Página do Dia'...")
    page.get_by_role("link", name="Página do Dia").click()
    expect(page.get_by_role("heading", name="Página do Dia")).to_be_visible()

    # --- 5. AJAX Task Management ---
    # Add a new task
    print("Adding a new task via AJAX...")
    task_name = "Verificar o sistema de tarefas AJAX"
    page.get_by_label("Nome da Tarefa").fill(task_name)
    page.get_by_label("Tipo").select_option("arbitraria")
    page.get_by_role("button", name="Adicionar Tarefa").click()

    # Wait for the success toast and the new task to appear
    expect(page.get_by_text("Tarefa adicionada!")).to_be_visible()
    new_task = page.locator(f".tarefa-item:has-text('{task_name}')")
    expect(new_task).to_be_visible()

    # Complete the task
    print("Completing the task...")
    task_checkbox = new_task.get_by_role("checkbox")
    task_label = new_task.get_by_label(task_name)

    expect(task_label).not_to_have_class(re.compile(r"concluida"))
    task_checkbox.check()
    expect(page.get_by_text("Tarefa concluída!")).to_be_visible()
    expect(task_label).to_have_class(re.compile(r"concluida"))

    # Delete the task
    print("Deleting the task...")
    delete_button = new_task.get_by_role("button", name="×")
    delete_button.click()
    # Confirm deletion in the SweetAlert dialog
    expect(page.get_by_role("heading", name="Tem a certeza?")).to_be_visible()
    page.get_by_role("button", name="Sim, remover!").click()
    expect(page.get_by_text("Tarefa removida.")).to_be_visible()
    expect(new_task).not_to_be_visible()

    # --- 6. Side Menu Collapse ---
    print("Testing side menu collapse...")
    main_content = page.locator(".conteudo-principal")
    initial_margin = page.evaluate('(element) => window.getComputedStyle(element).marginLeft', main_content)

    # The toggle button is inside the header of the menu
    collapse_button = page.locator(".menu-toggle-btn")
    expect(collapse_button).to_be_visible()
    collapse_button.click()

    # Wait for the transition to finish
    page.wait_for_timeout(500)

    final_margin = page.evaluate('(element) => window.getComputedStyle(element).marginLeft', main_content)

    assert initial_margin != final_margin, "Side menu margin did not change after collapse."
    print("Side menu collapsed successfully.")

    # --- 7. Final Screenshot ---
    print("Taking final screenshot...")
    page.screenshot(path="jules-scratch/verification/verification.png")
    print("Verification script finished successfully.")


def main():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        try:
            run_verification(page)
        except Exception as e:
            print(f"An error occurred: {e}")
            page.screenshot(path="jules-scratch/verification/error.png")
        finally:
            browser.close()

if __name__ == "__main__":
    main()
